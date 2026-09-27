<!DOCTYPE html>
<html>
<head>
<meta charset="utf-8">
<title>{{ ($cv['full_name'] ?? null) ?: 'CV' }}</title>
<style>
    /* dompdf has limited CSS support (no flexbox/grid) — keep this simple
       and block/float based rather than reusing the Tailwind markup. */
    @page { margin: 36px 42px 60px 42px; }
    body {
        font-family: Helvetica, Arial, sans-serif;
        font-size: 10.5px;
        color: #23303F;
        line-height: 1.5;
    }
    h1, h2 {
        font-family: Georgia, "Times New Roman", serif;
        color: #0A1F38;
        margin: 0;
    }
    h1 { font-size: 22px; }
    h2 {
        font-size: 13px;
        border-bottom: 1px solid #B8863D;
        padding-bottom: 4px;
        margin-bottom: 8px;
    }
    .header { margin-bottom: 18px; }
    .title { font-size: 12px; color: #5B6B7C; margin-top: 2px; }
    .contact-line { font-size: 9.5px; color: #5B6B7C; margin-top: 6px; }
    .contact-line span:not(:last-child)::after { content: "  \2022  "; color: #B8863D; }
    section { margin-bottom: 16px; }
    .entry { margin-bottom: 10px; }
    .entry-title { font-size: 11px; font-weight: bold; color: #0A1F38; }
    .entry-meta { font-size: 9.5px; color: #5B6B7C; margin-bottom: 3px; }
    .entry-desc { font-size: 10px; }
    .tag-list span {
        display: inline-block;
        border: 1px solid #E4D8BE;
        background: #FBF6EC;
        color: #7A5A20;
        border-radius: 3px;
        padding: 2px 7px;
        margin: 0 6px 6px 0;
        font-size: 9.5px;
    }
    .cv-footer {
        position: fixed;
        bottom: -40px;
        left: 0;
        right: 0;
        text-align: center;
        font-size: 8.5px;
        color: #9AA6B2;
        border-top: 1px solid #E6E9ED;
        padding-top: 6px;
    }
</style>
</head>
<body>

    <div class="header">
        <h1>{{ ($cv['full_name'] ?? null) ?: 'Your name' }}</h1>
        @if(!empty($cv['professional_title']))
            <div class="title">{{ $cv['professional_title'] }}</div>
        @endif
        <div class="contact-line">
            @if(!empty($cv['email'])) <span>{{ $cv['email'] }}</span> @endif
            @if(!empty($cv['phone'])) <span>{{ $cv['phone'] }}</span> @endif
            @if(!empty($cv['location'])) <span>{{ $cv['location'] }}</span> @endif
            @if(!empty($cv['portfolio_url'])) <span>{{ $cv['portfolio_url'] }}</span> @endif
        </div>
    </div>

    @if(!empty($cv['professional_summary']))
    <section>
        <h2>Professional summary</h2>
        <div class="entry-desc">{{ $cv['professional_summary'] }}</div>
    </section>
    @endif

    @if(!empty(array_filter($cv['experience'] ?? [])))
    <section>
        <h2>Work experience</h2>
        @foreach ($cv['experience'] as $row)
            @continue(empty($row['title']) && empty($row['company']))
            <div class="entry">
                <div class="entry-title">{{ $row['title'] ?? '' }}@if(!empty($row['company'])) &mdash; {{ $row['company'] }}@endif</div>
                <div class="entry-meta">
                    {{ $row['location'] ?? '' }}
                    @if(!empty($row['start_date']))
                        &nbsp;&middot;&nbsp;{{ \Illuminate\Support\Carbon::parse($row['start_date'])->format('M Y') }}
                        &ndash;
                        {{ !empty($row['is_current']) ? 'Present' : (!empty($row['end_date']) ? \Illuminate\Support\Carbon::parse($row['end_date'])->format('M Y') : '') }}
                    @endif
                </div>
                @if(!empty($row['description']))
                    <div class="entry-desc">{{ $row['description'] }}</div>
                @endif
            </div>
        @endforeach
    </section>
    @endif

    @if(!empty(array_filter($cv['education'] ?? [])))
    <section>
        <h2>Education</h2>
        @foreach ($cv['education'] as $row)
            @continue(empty($row['degree']) && empty($row['institution']))
            <div class="entry">
                <div class="entry-title">{{ $row['degree'] ?? '' }}</div>
                <div class="entry-meta">
                    {{ $row['institution'] ?? '' }}
                    @if(!empty($row['location'])) &nbsp;&middot;&nbsp;{{ $row['location'] }} @endif
                    @if(!empty($row['start_year']) || !empty($row['end_year']))
                        &nbsp;&middot;&nbsp;{{ $row['start_year'] ?? '' }}&ndash;{{ $row['end_year'] ?? '' }}
                    @endif
                </div>
            </div>
        @endforeach
    </section>
    @endif

    @if(!empty(array_filter($cv['skills'] ?? [])))
    <section>
        <h2>Skills</h2>
        <div class="tag-list">
            @foreach ($cv['skills'] as $row)
                @continue(empty($row['name']))
                <span>{{ $row['name'] }}@if(!empty($row['level'])) &nbsp;&middot;&nbsp;{{ ucfirst($row['level']) }}@endif</span>
            @endforeach
        </div>
    </section>
    @endif

    @if(!empty(array_filter($cv['certifications'] ?? [])))
    <section>
        <h2>Certifications</h2>
        @foreach ($cv['certifications'] as $row)
            @continue(empty($row['name']))
            <div class="entry">
                <div class="entry-title">{{ $row['name'] }}</div>
                <div class="entry-meta">
                    {{ $row['issuer'] ?? '' }}
                    @if(!empty($row['issue_date'])) &nbsp;&middot;&nbsp;{{ \Illuminate\Support\Carbon::parse($row['issue_date'])->format('M Y') }} @endif
                </div>
            </div>
        @endforeach
    </section>
    @endif

    @if(!empty(array_filter($cv['languages'] ?? [])))
    <section>
        <h2>Languages</h2>
        <div class="tag-list">
            @foreach ($cv['languages'] as $row)
                @continue(empty($row['name']))
                <span>{{ $row['name'] }}@if(!empty($row['level'])) &nbsp;&middot;&nbsp;{{ ucfirst($row['level']) }}@endif</span>
            @endforeach
        </div>
    </section>
    @endif

    @if(!empty(array_filter($cv['projects'] ?? [])))
    <section>
        <h2>Projects</h2>
        @foreach ($cv['projects'] as $row)
            @continue(empty($row['name']))
            <div class="entry">
                <div class="entry-title">{{ $row['name'] }}@if(!empty($row['role'])) &mdash; {{ $row['role'] }}@endif</div>
                @if(!empty($row['tech']))
                    <div class="entry-meta">{{ $row['tech'] }}</div>
                @endif
                @if(!empty($row['description']))
                    <div class="entry-desc">{{ $row['description'] }}</div>
                @endif
            </div>
        @endforeach
    </section>
    @endif

    <div class="cv-footer">Built by Planet Job</div>

</body>
</html>
