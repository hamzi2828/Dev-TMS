@can('edit', $candidate)
    <li class="nav-item border border-top-0 border-start-0">
        <a href="{{ route ('candidates.edit', ['candidate' => $candidate -> id]) }}" type="button"
           class="nav-link {{ request () -> routeIs ('candidates.edit') ? 'active' : '' }}">
            Personal Information
        </a>
    </li>
@endcan

@can('view', $candidate)
    <li class="nav-item border border-top-0 border-start-0">
        <a href="{{ route ('candidates.show', ['candidate' => $candidate -> id]) }}" type="button"
           class="nav-link {{ request () -> routeIs ('candidates.show') ? 'active' : '' }}">
            View Candidate
        </a>
    </li>
@endcan

@can('mainMenu', \App\Models\CandidateInterview::class)
    <li class="nav-item border border-top-0 border-start-0">
        @if($candidate -> interview)
            <a href="{{ route ('candidates.interviews.edit', ['candidate' => $candidate -> id, 'interview' => $candidate -> interview -> id]) }}"
               type="button"
               class="nav-link {{ request () -> routeIs ('candidates.interviews.*') ? 'active' : '' }}">
                Interview
            </a>
        @else
            <a href="{{ route ('candidates.interviews.create', ['candidate' => $candidate -> id]) }}" type="button"
               class="nav-link {{ request () -> routeIs ('candidates.interviews.*') ? 'active' : '' }}">
                Interview
            </a>
        @endif
    </li>
@endcan

@can('mainMenu', \App\Models\CandidateMedical::class)
    <li class="nav-item border border-top-0 border-start-0">
        @if($candidate -> medical)
            <a href="{{ route ('candidates.medicals.edit', ['candidate' => $candidate -> id, 'medical' => $candidate -> medical -> id]) }}"
               type="button"
               class="nav-link {{ request () -> routeIs ('candidates.medicals.*') ? 'active' : '' }}">
                Medical
            </a>
        @else
            <a href="{{ route ('candidates.medicals.create', ['candidate' => $candidate -> id]) }}" type="button"
               class="nav-link {{ request () -> routeIs ('candidates.medicals.*') ? 'active' : '' }}">
                Medical
            </a>
        @endif
    </li>
@endcan

@can('mainMenu', \App\Models\CandidatePaymentFollowUp::class)
    <li class="nav-item border border-top-0 border-start-0">
        @if($candidate -> payment_follow_up)
            <a href="{{ route ('candidates.payment-follow-up.edit', ['candidate' => $candidate -> id, 'payment_follow_up' => $candidate -> payment_follow_up -> id]) }}"
               type="button"
               class="nav-link {{ request () -> routeIs ('candidates.payment-follow-up.*') ? 'active' : '' }}">
                Payment Follow Up
            </a>
        @else
            <a href="{{ route ('candidates.payment-follow-up.create', ['candidate' => $candidate -> id]) }}"
               type="button"
               class="nav-link {{ request () -> routeIs ('candidates.payment-follow-up.*') ? 'active' : '' }}">
                Payment Follow Up
            </a>
        @endif
    </li>
@endcan

@can('mainMenu', \App\Models\CandidateDocumentReady::class)
    <li class="nav-item border border-top-0 border-start-0">
        @if($candidate -> document_ready)
            <a href="{{ route ('candidates.document-ready.edit', ['candidate' => $candidate -> id, 'document_ready' => $candidate -> document_ready -> id]) }}"
               type="button"
               class="nav-link {{ request () -> routeIs ('candidates.document-ready.*') ? 'active' : '' }}">
                Documents Ready
            </a>
        @else
            <a href="{{ route ('candidates.document-ready.create', ['candidate' => $candidate -> id]) }}" type="button"
               class="nav-link {{ request () -> routeIs ('candidates.document-ready.*') ? 'active' : '' }}">
                Documents Ready
            </a>
        @endif
    </li>
@endcan

@can('mainMenu', \App\Models\CandidateCompanyRequisitionJob::class)
    <li class="nav-item border border-top-0 border-start-0">
        @if($candidate -> requisition)
            <a href="{{ route ('candidates.requisitions.edit', ['candidate' => $candidate -> id, 'requisition' => $candidate -> requisition -> id]) }}"
               type="button"
               class="nav-link {{ request () -> routeIs ('candidates.requisitions.*') ? 'active' : '' }}">
                MRF
            </a>
        @else
            <a href="{{ route ('candidates.requisitions.create', ['candidate' => $candidate -> id]) }}" type="button"
               class="nav-link {{ request () -> routeIs ('candidates.requisitions.*') ? 'active' : '' }}">
                MRF
            </a>
        @endif
    </li>
@endcan

@can('mainMenu', \App\Models\CandidateVisa::class)
    <li class="nav-item border border-top-0 border-start-0">
        @if($candidate -> visa)
            <a href="{{ route ('candidates.visas.edit', ['candidate' => $candidate -> id, 'visa' => $candidate -> visa -> id]) }}"
               type="button"
               class="nav-link {{ request () -> routeIs ('candidates.visas.*') ? 'active' : '' }}">
                Visa
            </a>
        @else
            <a href="{{ route ('candidates.visas.create', ['candidate' => $candidate -> id]) }}" type="button"
               class="nav-link {{ request () -> routeIs ('candidates.visas.*') ? 'active' : '' }}">
                Visa
            </a>
        @endif
    </li>
@endcan

@can('mainMenu', \App\Models\CandidateVisaFollowUp::class)
    <li class="nav-item border border-top-0 border-start-0">
        @if($candidate -> visa_follow_up)
            <a href="{{ route ('candidates.visa-follow-up.edit', ['candidate' => $candidate -> id, 'visa_follow_up' => $candidate -> visa_follow_up -> id]) }}"
               type="button"
               class="nav-link {{ request () -> routeIs ('candidates.visa-follow-up.*') ? 'active' : '' }}">
                Visa Follow Up
            </a>
        @else
            <a href="{{ route ('candidates.visa-follow-up.create', ['candidate' => $candidate -> id]) }}" type="button"
               class="nav-link {{ request () -> routeIs ('candidates.visa-follow-up.*') ? 'active' : '' }}">
                Visa Follow Up
            </a>
        @endif
    </li>
@endcan

@can('mainMenu', \App\Models\CandidateProtector::class)
    <li class="nav-item border border-top-0 border-start-0">
        @if($candidate -> protector)
            <a href="{{ route ('candidates.protectors.edit', ['candidate' => $candidate -> id, 'protector' => $candidate -> protector -> id]) }}"
               type="button"
               class="nav-link {{ request () -> routeIs ('candidates.protectors.*') ? 'active' : '' }}">
                Protector
            </a>
        @else
            <a href="{{ route ('candidates.protectors.create', ['candidate' => $candidate -> id]) }}" type="button"
               class="nav-link {{ request () -> routeIs ('candidates.protectors.*') ? 'active' : '' }}">
                Protector
            </a>
        @endif
    </li>
@endcan

@can('mainMenu', \App\Models\CandidateTicket::class)
    <li class="nav-item border border-top-0 border-start-0">
        @if($candidate -> ticket)
            <a href="{{ route ('candidates.tickets.edit', ['candidate' => $candidate -> id, 'ticket' => $candidate -> ticket -> id]) }}"
               type="button"
               class="nav-link {{ request () -> routeIs ('candidates.tickets.*') ? 'active' : '' }}">
                Ticketing
            </a>
        @else
            <a href="{{ route ('candidates.tickets.create', ['candidate' => $candidate -> id]) }}" type="button"
               class="nav-link {{ request () -> routeIs ('candidates.tickets.*') ? 'active' : '' }}">
                Ticketing
            </a>
        @endif
    </li>
@endcan

@can('mainMenu', \App\Models\CandidateTicketFollowUp::class)
    <li class="nav-item border border-top-0 border-start-0">
        @if($candidate -> ticket_follow_up)
            <a href="{{ route ('candidates.ticket-follow-up.edit', ['candidate' => $candidate -> id, 'ticket_follow_up' => $candidate -> ticket_follow_up -> id]) }}"
               type="button"
               class="nav-link {{ request () -> routeIs ('candidates.ticket-follow-up.*') ? 'active' : '' }}">
                Ticket Follow Up
            </a>
        @else
            <a href="{{ route ('candidates.ticket-follow-up.create', ['candidate' => $candidate -> id]) }}"
               type="button"
               class="nav-link {{ request () -> routeIs ('candidates.ticket-follow-up.*') ? 'active' : '' }}">
                Ticket Follow Up
            </a>
        @endif
    </li>
@endcan

@can('attachments', \App\Models\Candidate::class)
    <li class="nav-item border border-top-0 border-start-0">
        <a href="{{ route ('candidates.attachments', ['candidate' => $candidate -> id]) }}"
           type="button"
           class="nav-link {{ request () -> routeIs ('candidates.attachments') ? 'active' : '' }}">
            Attachments
        </a>
    </li>
@endcan

@can('trade_change', \App\Models\Candidate::class)
    <li class="nav-item border border-top-0 border-start-0">
        <a href="{{ route ('candidates.trade-change', ['candidate' => $candidate -> id]) }}" type="button"
           class="nav-link {{ request () -> routeIs ('candidates.trade-change') ? 'active' : '' }}">
            Trade Change
        </a>
    </li>
@endcan

@can('billing', \App\Models\Candidate::class)
    <li class="nav-item border border-top-0 border-start-0">
        <a href="{{ route ('candidates.billing', ['candidate' => $candidate -> id]) }}" type="button"
           class="nav-link {{ request () -> routeIs ('candidates.billing') ? 'active' : '' }}">
            Payments
        </a>
    </li>
@endcan

@can('create', \App\Models\CandidateBackOut::class)
    <li class="nav-item border border-top-0 border-start-0">
        @if($candidate -> back_out)
            <a href="{{ route ('candidates.back-out.edit', ['candidate' => $candidate -> id, 'back_out' => $candidate -> back_out -> id]) }}"
               type="button"
               class="nav-link {{ request () -> routeIs ('candidates.back-out.*') ? 'active' : '' }}">
                Back Out
            </a>
        @else
            <a href="{{ route ('candidates.back-out.create', ['candidate' => $candidate -> id]) }}" type="button"
               class="nav-link {{ request () -> routeIs ('candidates.back-out.*') ? 'active' : '' }}">
                Back Out
            </a>
        @endif
    </li>
@endcan