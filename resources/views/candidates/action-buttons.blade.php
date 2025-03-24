@can('print_test_slip', $candidate)
    <a href="{{ route ('invoices.candidate-test-fee-slip', ['candidate' => $candidate -> id]) }}"
       class="text-body" data-bs-toggle="tooltip"
       data-bs-placement="top" target="_blank"
       data-bs-custom-class="tooltip-warning"
       title="Test Fee Receipt">
        <i class="ti ti-receipt-2 ti-sm me-2"></i>
    </a>
@endcan

@can('print_bio_data_form', $candidate)
    <a href="{{ route ('invoices.candidate-bio-data', ['candidate' => $candidate -> id]) }}"
       class="text-body" data-bs-toggle="tooltip"
       data-bs-placement="top" target="_blank"
       data-bs-custom-class="tooltip-info"
       title="BioData Form">
        <i class="ti ti-printer ti-sm me-2"></i>
    </a>
@endcan

@can('print_candidates_ticket', $candidate)
    <a href="{{ route ('invoices.candidate-ticket', ['candidate' => $candidate -> id]) }}"
       class="text-body" data-bs-toggle="tooltip"
       data-bs-placement="top" target="_blank"
       data-bs-custom-class="tooltip-dark"
       title="Ticket">
        <i class="ti ti-ticket ti-sm me-2"></i>
    </a>
@endcan

@if($candidate -> medical)
    @can('print_medical_slip', $candidate -> medical)
        <a href="{{ route ('invoices.medical-receipt', ['candidate' => $candidate -> id, 'medical' => $candidate -> medical -> id]) }}"
           class="text-body" data-bs-toggle="tooltip"
           data-bs-placement="top" target="_blank"
           data-bs-custom-class="tooltip-dark"
           title="Medical Slip">
            <i class="ti ti-report-medical ti-sm me-2"></i>
        </a>
    @endcan
@endif

@can('delete', $candidate)
    <form method="post" id="delete-record-form-{{ $candidate -> id }}"
          action="{{ route ('candidates.destroy', ['candidate' => $candidate -> id]) }}">
        @method('DELETE')
        @csrf
        <button type="button" data-bs-toggle="tooltip"
                data-bs-placement="top"
                data-bs-custom-class="tooltip-danger"
                title="Delete"
                class="text-body delete-record bg-transparent border-0 p-0"
                onclick="delete_confirmation({{ $candidate -> id }})">
            <i class="ti ti-trash ti-sm"></i>
        </button>
    </form>
@endcan