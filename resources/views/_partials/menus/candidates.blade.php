@can('mainMenu', \App\Models\Candidate::class)
    <li class="menu-item {{ (request () -> routeIs ('candidates.index') || request () -> routeIs ('candidates.create') || request () -> routeIs ('candidates.edit')) ? 'active open' : '' }}">
        <a href="javascript:void(0);" class="menu-link menu-toggle">
            <i class="menu-icon tf-icons ti ti-man"></i>
            <div data-i18n="Candidates">Candidates</div>
        </a>
        <ul class="menu-sub">
            @can('all', \App\Models\Candidate::class)
                <li class="menu-item {{ request () -> routeIs ('candidates.index') ? 'active' : '' }}">
                    <a href="{{ route ('candidates.index') }}" class="menu-link">
                        <div data-i18n="All Candidates">All Candidates</div>
                    </a>
                </li>
            @endcan
            
            @can('create', \App\Models\Candidate::class)
                <li class="menu-item {{ request () -> routeIs ('candidates.create') ? 'active' : '' }}">
                    <a href="{{ route ('candidates.create') }}" class="menu-link">
                        <div data-i18n="Add Candidate">Add Candidate</div>
                    </a>
                </li>
            @endcan
        </ul>
    </li>
@endcan

@can('mainMenu', \App\Models\CandidateInterview::class)
    <li class="menu-item {{ request () -> routeIs ('candidates.interview-candidates') ? 'active' : '' }}">
        <a href="{{ route ('candidates.interview-candidates') }}" class="menu-link">
            <i class="menu-icon tf-icons ti ti-device-landline-phone"></i>
            <div data-i18n="Interview">Interview</div>
        </a>
    </li>
@endcan

@can('mainMenu', \App\Models\CandidateMedical::class)
    <li class="menu-item {{ request () -> routeIs ('candidates.medical-candidates') ? 'active' : '' }}">
        <a href="{{ route ('candidates.medical-candidates') }}" class="menu-link">
            <i class="menu-icon tf-icons ti ti-microscope"></i>
            <div data-i18n="Medical">Medical</div>
        </a>
    </li>
@endcan

@can('mainMenu', \App\Models\CandidateDocumentReady::class)
    <li class="menu-item {{ request () -> routeIs ('candidates.document-ready-candidates') ? 'active' : '' }}">
        <a href="{{ route ('candidates.document-ready-candidates') }}" class="menu-link">
            <i class="menu-icon tf-icons ti ti-briefcase"></i>
            <div data-i18n="Documents Ready">Documents Ready</div>
        </a>
    </li>
@endcan

@can('mainMenu', \App\Models\CandidateVisa::class)
    <li class="menu-item {{ request () -> routeIs ('candidates.visa-candidates') ? 'active' : '' }}">
        <a href="{{ route ('candidates.visa-candidates') }}" class="menu-link">
            <i class="menu-icon tf-icons ti ti-brand-visa"></i>
            <div data-i18n="Visa">Visa</div>
        </a>
    </li>
@endcan

@can('mainMenu', \App\Models\CandidateProtector::class)
    <li class="menu-item {{ request () -> routeIs ('candidates.protector-candidates') ? 'active' : '' }}">
        <a href="{{ route ('candidates.protector-candidates') }}" class="menu-link">
            <i class="menu-icon tf-icons ti ti-shield-check-filled"></i>
            <div data-i18n="Protector">Protector</div>
        </a>
    </li>
@endcan

@can('mainMenu', \App\Models\CandidateTicket::class)
    <li class="menu-item {{ request () -> routeIs ('candidates.ticket-candidates') ? 'active' : '' }}">
        <a href="{{ route ('candidates.ticket-candidates') }}" class="menu-link">
            <i class="menu-icon tf-icons ti ti-ticket"></i>
            <div data-i18n="Ticket">Ticket</div>
        </a>
    </li>
@endcan

@can('case_closed', \App\Models\Candidate::class)
<li class="menu-item {{ request () -> routeIs ('candidates.case-closed-candidates') ? 'active' : '' }}">
    <a href="{{ route ('candidates.case-closed-candidates') }}" class="menu-link">
        <i class="menu-icon tf-icons ti ti-plane-departure"></i>
        <div data-i18n="Departed">Departed</div>
    </a>
</li>
@endcan