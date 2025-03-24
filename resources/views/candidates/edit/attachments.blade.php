<div class="card-body pt-1 pb-1">
    @include('candidates.edit.candidate-info')
    <div class="row">
        <div class="card-datatable table-responsive">
            <table class="table table-hover table-bordered">
                <thead class="border-top">
                <tr>
                    <th>Title</th>
                    <th>Link</th>
                    <th>Actions</th>
                </tr>
                </thead>
                <tbody>
                <tr>
                    <td>Picture</td>
                    <td>
                        <a href="{{ $candidate -> document ?-> picture }}" class="text-decoration-underline"
                           target="_blank">
                            {{ $candidate -> document ?-> picture }}
                        </a>
                    </td>
                    <td>
                        @if($candidate -> document && !empty(trim ($candidate -> document -> picture)))
                            <div>
                                <a href="{{ $candidate -> document -> picture }}"
                                   download="{{ $candidate -> fullName() }} - Picture">
                                    <i class="tf-icons ti ti-download"></i>
                                </a>
                                <a href="{{ $candidate -> document -> picture }}" target="_blank">
                                    <i class="tf-icons ti ti-photo"></i>
                                </a>
                            </div>
                        @endif
                    </td>
                </tr>
                <tr>
                    <td>Passport</td>
                    <td>
                        <a href="{{ $candidate -> document ?-> passport }}" class="text-decoration-underline"
                           target="_blank">
                            {{ $candidate -> document ?-> passport }}
                        </a>
                    </td>
                    <td>
                        @if($candidate -> document && !empty(trim ($candidate -> document -> passport)))
                            <div>
                                <a href="{{ $candidate -> document -> passport }}"
                                   download="{{ $candidate -> fullName() }} - Passport">
                                    <i class="tf-icons ti ti-download"></i>
                                </a>
                                <a href="{{ $candidate -> document -> passport }}" target="_blank">
                                    <i class="tf-icons ti ti-photo"></i>
                                </a>
                            </div>
                        @endif
                    </td>
                </tr>
                <tr>
                    <td>CNIC (Front)</td>
                    <td>
                        <a href="{{ $candidate -> document ?-> cnic_front }}" class="text-decoration-underline"
                           target="_blank">
                            {{ $candidate -> document ?-> cnic_front }}
                        </a>
                    </td>
                    <td>
                        @if($candidate -> document && !empty(trim ($candidate -> document -> cnic_front)))
                            <div>
                                <a href="{{ $candidate -> document -> cnic_front }}"
                                   download="{{ $candidate -> fullName() }} - CNIC Front" target="_blank">
                                    <i class="tf-icons ti ti-download"></i>
                                </a>
                                <a href="{{ $candidate -> document -> cnic_front }}" target="_blank">
                                    <i class="tf-icons ti ti-photo"></i>
                                </a>
                            </div>
                        @endif
                    </td>
                </tr>
                <tr>
                    <td>CNIC (Back)</td>
                    <td>
                        <a href="{{ $candidate -> document ?-> cnic_back }}" class="text-decoration-underline"
                           target="_blank">
                            {{ $candidate -> document ?-> cnic_back }}
                        </a>
                    </td>
                    <td>
                        @if($candidate -> document && !empty(trim ($candidate -> document -> cnic_back)))
                            <div>
                                <a href="{{ $candidate -> document -> cnic_back }}"
                                   download="{{ $candidate -> fullName() }} - CNIC Back" target="_blank">
                                    <i class="tf-icons ti ti-download"></i>
                                </a>
                                <a href="{{ $candidate -> document -> cnic_back }}" target="_blank">
                                    <i class="tf-icons ti ti-photo"></i>
                                </a>
                            </div>
                        @endif
                    </td>
                </tr>
                <tr>
                    <td>EPT Result (Front)</td>
                    <td>
                        <a href="{{ $candidate -> interview ?-> document ?-> ept }}" class="text-decoration-underline"
                           target="_blank">
                            {{ $candidate -> interview ?-> document ?-> ept }}
                        </a>
                    </td>
                    <td>
                        @if($candidate -> interview ?-> document && !empty(trim ($candidate -> interview ?-> document ?-> ept)))
                            <div>
                                <a href="{{ $candidate -> interview ?-> document ?-> ept }}"
                                   download="{{ $candidate -> fullName() }} - EPT Result" target="_blank">
                                    <i class="tf-icons ti ti-download"></i>
                                </a>
                                <a href="{{ $candidate -> interview ?-> document ?-> ept }}" target="_blank">
                                    <i class="tf-icons ti ti-photo"></i>
                                </a>
                            </div>
                        @endif
                    </td>
                </tr>
                <tr>
                    <td>EPT Result (Back)</td>
                    <td>
                        <a href="{{ $candidate -> interview ?-> document ?-> ept_back }}"
                           class="text-decoration-underline"
                           target="_blank">
                            {{ $candidate -> interview ?-> document ?-> ept_back }}
                        </a>
                    </td>
                    <td>
                        @if($candidate -> interview ?-> document && !empty(trim ($candidate -> interview ?-> document ?-> ept_back)))
                            <div>
                                <a href="{{ $candidate -> interview ?-> document ?-> ept_back }}"
                                   download="{{ $candidate -> fullName() }} - EPT Back Result" target="_blank">
                                    <i class="tf-icons ti ti-download"></i>
                                </a>
                                <a href="{{ $candidate -> interview ?-> document ?-> ept_back }}" target="_blank">
                                    <i class="tf-icons ti ti-photo"></i>
                                </a>
                            </div>
                        @endif
                    </td>
                </tr>
                <tr>
                    <td>Assessment-Aptitude (Front)</td>
                    <td>
                        <a href="{{ $candidate -> interview ?-> document ?-> assessment_aptitude_front }}"
                           class="text-decoration-underline"
                           target="_blank">
                            {{ $candidate -> interview ?-> document ?-> assessment_aptitude_front }}
                        </a>
                    </td>
                    <td>
                        @if($candidate -> interview ?-> document && !empty(trim ($candidate -> interview ?-> document ?-> assessment_aptitude_front)))
                            <div>
                                <a href="{{ $candidate -> interview ?-> document ?-> assessment_aptitude_front }}"
                                   download="{{ $candidate -> fullName() }} - Assessment-Aptitude-Front"
                                   target="_blank">
                                    <i class="tf-icons ti ti-download"></i>
                                </a>
                                <a href="{{ $candidate -> interview ?-> document ?-> assessment_aptitude_front }}"
                                   target="_blank">
                                    <i class="tf-icons ti ti-photo"></i>
                                </a>
                            </div>
                        @endif
                    </td>
                </tr>
                <tr>
                    <td>Assessment-Aptitude (Back)</td>
                    <td>
                        <a href="{{ $candidate -> interview ?-> document ?-> assessment_aptitude_back }}"
                           class="text-decoration-underline"
                           target="_blank">
                            {{ $candidate -> interview ?-> document ?-> assessment_aptitude_back }}
                        </a>
                    </td>
                    <td>
                        @if($candidate -> interview ?-> document && !empty(trim ($candidate -> interview ?-> document ?-> assessment_aptitude_back)))
                            <div>
                                <a href="{{ $candidate -> interview ?-> document ?-> assessment_aptitude_back }}"
                                   download="{{ $candidate -> fullName() }} - Assessment-Aptitude-Front"
                                   target="_blank">
                                    <i class="tf-icons ti ti-download"></i>
                                </a>
                                <a href="{{ $candidate -> interview ?-> document ?-> assessment_aptitude_back }}"
                                   target="_blank">
                                    <i class="tf-icons ti ti-photo"></i>
                                </a>
                            </div>
                        @endif
                    </td>
                </tr>
                <tr>
                    <td>Spoken English</td>
                    <td>
                        <a href="{{ $candidate -> interview ?-> document ?-> english }}"
                           class="text-decoration-underline"
                           target="_blank">
                            {{ $candidate -> interview ?-> document ?-> english }}
                        </a>
                    </td>
                    <td>
                        @if($candidate -> interview ?-> document && !empty(trim ($candidate -> interview ?-> document ?-> english)))
                            <div>
                                <a href="{{ $candidate -> interview ?-> document ?-> english }}"
                                   download="{{ $candidate -> fullName() }} - Spoken English" target="_blank">
                                    <i class="tf-icons ti ti-download"></i>
                                </a>
                                <a href="{{ $candidate -> interview ?-> document ?-> english }}" target="_blank">
                                    <i class="tf-icons ti ti-photo"></i>
                                </a>
                            </div>
                        @endif
                    </td>
                </tr>
                <tr>
                    <td>Medical Test Result</td>
                    <td>
                        <a href="{{ $candidate -> medical ?-> file }}" class="text-decoration-underline"
                           target="_blank">
                            {{ $candidate -> medical ?-> file }}
                        </a>
                    </td>
                    <td>
                        @if($candidate -> medical && !empty(trim ($candidate -> medical -> file)))
                            <div>
                                <a href="{{ $candidate -> medical -> file }}"
                                   download="{{ $candidate -> fullName() }} - Medical Certificate"
                                   target="_blank">
                                    <i class="tf-icons ti ti-download"></i>
                                </a>
                                <a href="{{ $candidate -> medical -> file }}" target="_blank">
                                    <i class="tf-icons ti ti-photo"></i>
                                </a>
                            </div>
                        @endif
                    </td>
                </tr>
                <tr>
                    <td>Bio-Data Form</td>
                    <td>
                        <a href="{{ route ('invoices.candidate-bio-data', ['candidate' => $candidate -> id]) }}"
                           class="text-decoration-underline"
                           target="_blank">
                            {{ route ('invoices.candidate-bio-data', ['candidate' => $candidate -> id]) }}
                        </a>
                    </td>
                    <td>
                        <div>
                            <a href="{{ route ('invoices.candidate-bio-data', ['candidate' => $candidate -> id]) }}"
                               target="_blank">
                                <i class="tf-icons ti ti-download"></i>
                            </a>
                        </div>
                    </td>
                </tr>
                @if($candidate -> document_ready ?-> agreement_id)
                    <tr>
                        <td>Agreement</td>
                        <td>
                            <a href="{{ route ('invoices.agreement', ['candidate' => $candidate -> id, 'document_ready' => $candidate -> document_ready -> id]) }}"
                               class="text-decoration-underline"
                               target="_blank">
                                {{ route ('invoices.agreement', ['candidate' => $candidate -> id, 'document_ready' => $candidate -> document_ready -> id]) }}
                            </a>
                        </td>
                        <td>
                            <div>
                                <a href="{{ route ('invoices.agreement', ['candidate' => $candidate -> id, 'document_ready' => $candidate -> document_ready -> id]) }}"
                                   target="_blank">
                                    <i class="tf-icons ti ti-download"></i>
                                </a>
                            </div>
                        </td>
                    </tr>
                @endif
                <tr>
                    <td>Visa Copy</td>
                    <td>
                        <a href="{{ $candidate -> visa ?-> file }}" class="text-decoration-underline"
                           target="_blank">
                            {{ $candidate -> visa ?-> file }}
                        </a>
                    </td>
                    <td>
                        @if($candidate -> visa && !empty(trim ($candidate -> visa ?-> file)))
                            <div>
                                <a href="{{ $candidate -> visa ?-> file }}"
                                   download="{{ $candidate -> fullName() }} - Visa Copy"
                                   target="_blank">
                                    <i class="tf-icons ti ti-download"></i>
                                </a>
                                <a href="{{ $candidate -> visa ?-> file }}" target="_blank">
                                    <i class="tf-icons ti ti-photo"></i>
                                </a>
                            </div>
                        @endif
                    </td>
                </tr>
                <tr>
                    <td>Ticket Copy</td>
                    <td>
                        <a href="{{ $candidate -> ticket ?-> file }}" class="text-decoration-underline"
                           target="_blank">
                            {{ $candidate -> ticket ?-> file }}
                        </a>
                    </td>
                    <td>
                        @if($candidate -> ticket && !empty(trim ($candidate -> ticket ?-> file)))
                            <div>
                                <a href="{{ $candidate -> ticket ?-> file }}"
                                   download="{{ $candidate -> fullName() }} - Ticket Copy"
                                   target="_blank">
                                    <i class="tf-icons ti ti-download"></i>
                                </a>
                                <a href="{{ $candidate -> ticket ?-> file }}" target="_blank">
                                    <i class="tf-icons ti ti-photo"></i>
                                </a>
                            </div>
                        @endif
                    </td>
                </tr>
                <tr>
                    <td>Protector Copy</td>
                    <td>
                        <a href="{{ $candidate -> protector ?-> file }}" class="text-decoration-underline"
                           target="_blank">
                            {{ $candidate -> protector ?-> file }}
                        </a>
                    </td>
                    <td>
                        @if($candidate -> protector && !empty(trim ($candidate -> protector ?-> file)))
                            <div>
                                <a href="{{ $candidate -> protector ?-> file }}"
                                   download="{{ $candidate -> fullName() }} - Protector Copy"
                                   target="_blank">
                                    <i class="tf-icons ti ti-download"></i>
                                </a>
                                <a href="{{ $candidate -> protector ?-> file }}" target="_blank">
                                    <i class="tf-icons ti ti-photo"></i>
                                </a>
                            </div>
                        @endif
                    </td>
                </tr>
                <tr>
                    <td>Candidate Video</td>
                    <td>
                        <a href="{{ $candidate -> protector ?-> video }}" class="text-decoration-underline"
                           target="_blank">
                            {{ $candidate -> protector ?-> video }}
                        </a>
                    </td>
                    <td>
                        @if($candidate -> protector && !empty(trim ($candidate -> protector ?-> video)))
                            <div>
                                <a href="{{ $candidate -> protector ?-> video }}"
                                   download="{{ $candidate -> fullName() }} - Candidate Video"
                                   target="_blank">
                                    <i class="tf-icons ti ti-download"></i>
                                </a>
                                <a href="{{ $candidate -> protector ?-> video }}" target="_blank">
                                    <i class="tf-icons ti ti-video"></i>
                                </a>
                            </div>
                        @endif
                    </td>
                </tr>
                </tbody>
            </table>
        </div>
    </div>
</div>