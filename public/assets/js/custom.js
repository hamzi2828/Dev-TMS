let appPath         = $ ( 'meta[name="app-path"]' ).attr ( 'content' );
let selectedVoucher = null;

$ ( document ).on ( 'submit', 'form', function () {
    let button = $ ( 'button[type="submit"]' );
    button.html ( 'Processing...' );
    button.prop ( 'disabled', true );
} );

function reset_buttons () {
    let button = $ ( 'button[type="submit"]' );
    button.html ( 'Save' );
    button.prop ( 'disabled', false );
}

$ ( '.flatpickr-basic' ).flatpickr ();
$ ( ".chosen-select" ).chosen ();

function ajaxSetup () {
    $.ajaxSetup ( {
                      headers: {
                          'X-CSRF-TOKEN': $ ( 'meta[name="csrf-token"]' ).attr ( 'content' )
                      }
                  } );
}

function ajaxErrors ( xHR, exception ) {
    let msg = '';
    if ( xHR.status === 0 ) {
        msg = 'Not connect.\n Verify Network.';
    }
    else if ( xHR.status === 404 ) {
        msg = 'Requested page not found. [404]';
    }
    else if ( xHR.status === 500 ) {
        msg = 'Internal Server Error [500].';
    }
    else if ( xHR.status === 422 ) { // 422 Unprocessable Entity
        let errors = xHR.responseJSON.errors;
        Object.keys ( errors ).forEach ( key => {
            const errorMessages = errors[ key ];
            errorMessages.forEach ( message => {
                msg = message;
            } );
        } );
    }
    else if ( exception === 'parsererror' ) {
        msg = 'Requested JSON parse failed.';
    }
    else if ( exception === 'timeout' ) {
        msg = 'Time out error.';
    }
    else if ( exception === 'abort' ) {
        msg = 'Ajax request aborted.';
    }
    else {
        msg = 'Uncaught Error.\n' + xHR.responseText;
    }
    Swal.fire ( {
                    title         : "Error!",
                    text          : msg,
                    icon          : "error",
                    customClass   : { confirmButton: "btn btn-primary" },
                    buttonsStyling: !1
                } );
    
    $ ( 'button[type="submit"]' ).html ( 'Submit' );
    $ ( 'button[type="submit"]' ).prop ( 'disabled', false );
}

function ajaxSuccess ( message ) {
    Swal.fire ( {
                    title         : "Success!",
                    text          : message,
                    icon          : "success",
                    customClass   : { confirmButton: "btn btn-primary" },
                    buttonsStyling: !1
                } );
}

function init_datatable ( path ) {
    $ ( '#datatable' ).DataTable ( {
                                       order   : [ [ 0, 'asc' ] ],
                                       dom     :
                                           '<"row me-2"' +
                                           '<"col-md-2"<"me-3"l>>' +
                                           '<"col-md-10"<"dt-action-buttons text-xl-end text-lg-start text-md-end text-start d-flex align-items-center justify-content-end flex-md-row flex-column mb-3 mb-md-0"fB>>' +
                                           '>t' +
                                           '<"row mx-2"' +
                                           '<"col-sm-12 col-md-6"i>' +
                                           '<"col-sm-12 col-md-6"p>' +
                                           '>',
                                       language: {
                                           sLengthMenu      : '_MENU_',
                                           search           : '',
                                           searchPlaceholder: 'Search..'
                                       },
                                       
                                       buttons: [
                                           {
                                               extend   : 'collection',
                                               className: 'btn btn-label-secondary dropdown-toggle mx-3',
                                               text     : '<i class="ti ti-screen-share me-1 ti-xs"></i>Export',
                                               buttons  : [
                                                   {
                                                       extend       : 'csv',
                                                       text         : '<i class="ti ti-file-text me-2" ></i>Csv',
                                                       className    : 'dropdown-item',
                                                       exportOptions: {
                                                           columns: [ 1, 2, 3, 4, 5 ],
                                                           // prevent avatar to be display
                                                           format: {
                                                               body: function ( inner, coldex, rowdex ) {
                                                                   if ( inner.length <= 0 ) return inner;
                                                                   var el     = $.parseHTML ( inner );
                                                                   var result = '';
                                                                   $.each ( el, function ( index, item ) {
                                                                       if ( item.classList !== undefined && item.classList.contains ( 'user-name' ) ) {
                                                                           result = result + item.lastChild.firstChild.textContent;
                                                                       }
                                                                       else if ( item.innerText === undefined ) {
                                                                           result = result + item.textContent;
                                                                       }
                                                                       else result = result + item.innerText;
                                                                   } );
                                                                   return result;
                                                               }
                                                           }
                                                       }
                                                   },
                                               ]
                                           },
                                           {
                                               text     : '<i class="ti ti-plus me-0 me-sm-1 ti-xs"></i><span class="d-sm-inline-block text-white route" data-route="' + path + '">Add New</span>',
                                               className: 'add-new-redirect-link btn btn-primary text-white',
                                               action   : function () {
                                                   window.location.href = path;
                                               }
                                           }
                                       ],
                                   } );
}

function delete_confirmation ( id, formID = '' ) {
    Swal.fire ( {
                    title            : 'Are you sure?',
                    text             : "You won't be able to revert this!",
                    icon             : 'warning',
                    showCancelButton : true,
                    confirmButtonText: 'Yes, delete it!',
                    customClass      : {
                        confirmButton: 'btn btn-primary me-3',
                        cancelButton : 'btn btn-label-secondary'
                    },
                    buttonsStyling   : false
                } ).then ( function ( result ) {
        if ( result.value ) {
            if ( formID.length > 0 )
                $ ( '#' + formID ).submit ();
            else
                $ ( '#delete-record-form-' + id ).submit ();
        }
    } );
}

function close_confirmation ( id, formID = '' ) {
    Swal.fire ( {
                    title            : 'Are you sure?',
                    text             : "You won't be able to revert this!",
                    icon             : 'warning',
                    showCancelButton : true,
                    confirmButtonText: 'Yes, close it!',
                    customClass      : {
                        confirmButton: 'btn btn-primary me-3',
                        cancelButton : 'btn btn-label-secondary'
                    },
                    buttonsStyling   : false
                } ).then ( function ( result ) {
        if ( result.value ) {
            if ( formID.length > 0 )
                $ ( '#' + formID ).submit ();
            else
                $ ( '#close-record-form-' + id ).submit ();
        }
    } );
}

function get_account_head_type ( account_head_id, transaction_type, route ) {
    if ( account_head_id > 0 ) {
        ajaxSetup ();
        jQuery.ajax ( {
                          type      : 'GET',
                          url       : route,
                          data      : {
                              account_head_id,
                          },
                          beforeSend: function () {
                              $ ( '#' + transaction_type + '-debit' ).prop ( 'disabled', false );
                              $ ( '#' + transaction_type + '-credit' ).prop ( 'disabled', false );
                          },
                          success   : function ( response ) {
                              // $ ( '#' + transaction_type + '-' + response ).prop ( 'checked', true );
                          },
                          error     : function ( xHR, exception ) {
                              ajaxErrors ( xHR, exception );
                          }
                      } )
    }
}

// function addMoreTransactions ( route ) {
//
//     let rows    = $ ( '#rows' ).val ();
//     let nextRow = parseInt ( rows ) + 1;
//     $ ( '#rows' ).val ( nextRow );
//
//     ajaxSetup ();
//     jQuery.ajax ( {
//                       type   : 'GET',
//                       url    : route,
//                       data   : {
//                           nextRow
//                       },
//                       success: function ( response ) {
//                           $ ( '#add-more-transactions' ).append ( response );
//                           $ ( ".chosen-select-" + nextRow ).chosen ();
//                       },
//                       error  : function ( xHR, exception ) {
//                           ajaxErrors ( xHR, exception );
//                       }
//                   } )
// }
//
// $ ( document ).on ( 'change', '.initial-amount', function () {
//     let initial_amount = $ ( this ).val ();
//     $ ( '.first-transaction' ).val ( initial_amount );
// } );
//
// $ ( document ).on ( 'change', '.other-amounts', function () {
//     let iSum              = 0;
//     let first_transaction = $ ( '.first-transaction' ).val ();
//
//     $ ( '.other-amounts' ).each ( function () {
//         if ( jQuery ( this ).val () != '' && $ ( this ).val () >= 0 )
//             iSum = iSum + parseFloat ( $ ( this ).val () );
//     } );
//     $ ( '.other-transactions' ).val ( iSum );
//
//     if ( parseFloat ( first_transaction ) - parseFloat ( iSum ) == 0 )
//         $ ( '#multiple-transactions-btn' ).prop ( 'disabled', false );
//     else
//         $ ( '#multiple-transactions-btn' ).prop ( 'disabled', true );
// } );

function toggleSingleTransactions ( voucher, route ) {
    if ( voucher.length > 0 ) {
        reset_transactions ();
        if ( voucher === 'cpv' || voucher === 'bpv' ) {
            $ ( '#transaction-type-credit' ).prop ( 'checked', true );
            $ ( '#transaction-type-debit' ).prop ( 'disabled', true );
            
            $ ( '#transaction-type-2-debit' ).prop ( 'checked', true );
            $ ( '#transaction-type-2-credit' ).prop ( 'disabled', true );
        }
        else if ( voucher === 'crv' || voucher === 'brv' ) {
            $ ( '#transaction-type-debit' ).prop ( 'checked', true );
            $ ( '#transaction-type-credit' ).prop ( 'disabled', true );
            
            $ ( '#transaction-type-2-credit' ).prop ( 'checked', true );
            $ ( '#transaction-type-2-debit' ).prop ( 'disabled', true );
        }
        else {
            reset_transactions ();
        }
        
        if ( voucher === 'cpv' || voucher === 'crv' ) {
            load_account_head_transaction_dropdown ( 'cash', route );
            $ ( "#payment-mode" ).val ( 'cash' ).trigger ( 'change' );
        }
        else if ( voucher === 'bpv' || voucher === 'brv' ) {
            load_account_head_transaction_dropdown ( 'bank', route );
            $ ( "#payment-mode" ).val ( 'cheque' ).trigger ( 'change' );
        }
        else {
            load_account_head_transaction_dropdown ( 'all', route );
            $ ( "#payment-mode" ).val ( 'cash' ).trigger ( 'change' );
        }
    }
}

function load_account_head_transaction_dropdown ( type = '', route ) {
    if ( type.length > 0 ) {
        ajaxSetup ();
        jQuery.ajax ( {
                          type   : 'GET',
                          url    : route,
                          data   : {
                              type
                          },
                          success: function ( response ) {
                              let $firstAccountHead = $ ( '#first-account-head' );
                              $firstAccountHead.empty ();
                              $firstAccountHead.html ( '<option></option>' );
                              $firstAccountHead.append ( response );
                              $firstAccountHead.trigger ( "chosen:updated" );
                          },
                          error  : function ( xHR, exception ) {
                              ajaxErrors ( xHR, exception );
                          }
                      } )
    }
}

function toggleMultipleTransactions ( voucher, route ) {
    if ( voucher.length > 0 ) {
        
        let accountHeadID = $ ( '#first-account-head' ).val ();
        
        if ( voucher === 'cpv' || voucher === 'bpv' ) {
            reset_other_transactions ();
            $ ( '#transaction-type-credit' ).prop ( 'checked', true );
            $ ( '#transaction-type-debit' ).prop ( 'disabled', true );
            
            $ ( '.other-transactions-debit' ).prop ( 'checked', true );
            $ ( '.other-transactions-credit' ).prop ( 'disabled', true );
        }
        else if ( voucher === 'crv' || voucher === 'brv' ) {
            reset_other_transactions ();
            $ ( '#transaction-type-debit' ).prop ( 'checked', true );
            $ ( '#transaction-type-credit' ).prop ( 'disabled', true );
            
            $ ( '.other-transactions-credit' ).prop ( 'checked', true );
            $ ( '.other-transactions-debit' ).prop ( 'disabled', true );
        }
        else {
            // reset_other_transactions ();
        }
        if ( parseInt ( accountHeadID ) > 0 && selectedVoucher === voucher ) {
            // do not change the first transaction dropdown
        }
        else {
            if ( voucher === 'cpv' || voucher === 'crv' ) {
                load_account_head_transaction_dropdown ( 'cash', route );
                $ ( "#payment-mode" ).val ( 'cash' ).trigger ( 'change' );
            }
            else if ( voucher === 'bpv' || voucher === 'brv' ) {
                load_account_head_transaction_dropdown ( 'bank', route );
                $ ( "#payment-mode" ).val ( 'cheque' ).trigger ( 'change' );
            }
            else {
                load_account_head_transaction_dropdown ( 'all', route );
                $ ( "#payment-mode" ).val ( 'cash' ).trigger ( 'change' );
            }
        }
        selectedVoucher = voucher;
    }
}

function reset_other_transactions () {
    $ ( '#transaction-type-debit' ).prop ( 'checked', false );
    $ ( '#transaction-type-debit' ).prop ( 'disabled', false );
    $ ( '#transaction-type-credit' ).prop ( 'checked', false );
    $ ( '#transaction-type-credit' ).prop ( 'disabled', false );
    
    $ ( '.other-transactions-debit' ).prop ( 'checked', false );
    $ ( '.other-transactions-debit' ).prop ( 'disabled', false );
    $ ( '.other-transactions-credit' ).prop ( 'checked', false );
    $ ( '.other-transactions-credit' ).prop ( 'disabled', false );
}

function reset_transactions () {
    $ ( '#transaction-type-debit' ).prop ( 'checked', false );
    $ ( '#transaction-type-debit' ).prop ( 'disabled', false );
    $ ( '#transaction-type-credit' ).prop ( 'checked', false );
    $ ( '#transaction-type-credit' ).prop ( 'disabled', false );
    $ ( '#transaction-type-2-debit' ).prop ( 'checked', false );
    $ ( '#transaction-type-2-debit' ).prop ( 'disabled', false );
    $ ( '#transaction-type-2-credit' ).prop ( 'checked', false );
    $ ( '#transaction-type-2-credit' ).prop ( 'disabled', false );
}

jQuery ( '#payment-mode' ).on ( 'change', function () {
    if ( $ ( this ).val () === 'cheque' || $ ( this ).val () === 'online' ) {
        $ ( "#transaction-no" ).removeClass ( 'd-none' );
        $ ( "#transaction-no" ).prop ( 'required', true );
    }
    else {
        $ ( "#transaction-no" ).addClass ( 'd-none' );
        $ ( "#transaction-no" ).prop ( 'required', false );
    }
} )

function addMoreTransactions ( route = '' ) {
    
    let rows    = $ ( '#rows' ).val ();
    let nextRow = parseInt ( rows ) + 1;
    $ ( '#rows' ).val ( nextRow );
    
    ajaxSetup ();
    jQuery.ajax ( {
                      type   : 'GET',
                      url    : '/add-more-transactions',
                      data   : {
                          nextRow
                      },
                      success: function ( response ) {
                          $ ( '#add-more-transactions' ).append ( response );
                          $ ( ".chosen-select-" + nextRow ).chosen ();
                          
                          let value = '';
                          if ( $ ( '#transaction-type-debit' ).is ( ':checked' ) )
                              value = 'debit';
                          else if ( $ ( '#transaction-type-credit' ).is ( ':checked' ) )
                              value = 'credit';
                          
                          toggleMultipleTransactions ( $ ( '#voucher' ).val (), route );
                          toggleJVTransactionsAddMore ( value );
                      },
                      error  : function ( xHR, exception ) {
                          ajaxErrors ( xHR, exception );
                      }
                  } )
}

$ ( document ).on ( 'change', '.initial-amount', function () {
    let initial_amount = $ ( this ).val ();
    $ ( '.first-transaction' ).val ( initial_amount );
    sumOtherAmounts ();
} );

$ ( document ).on ( 'change', '.other-amounts', function () {
    let iSum              = 0;
    let first_transaction = $ ( '.first-transaction' ).val ();
    
    $ ( '.other-amounts' ).each ( function () {
        if ( jQuery ( this ).val () !== '' && $ ( this ).val () >= 0 )
            iSum = iSum + parseFloat ( $ ( this ).val () );
    } );
    $ ( '.other-transactions' ).val ( iSum );
    
    if ( parseFloat ( first_transaction ) - parseFloat ( iSum ) === 0 )
        $ ( '#multiple-transactions-btn' ).prop ( 'disabled', false );
    else
        $ ( '#multiple-transactions-btn' ).prop ( 'disabled', true );
    
} );

function sumOtherAmounts () {
    let iSum              = 0;
    let first_transaction = $ ( '.initial-amount' ).val ();
    
    $ ( '.other-amounts' ).each ( function () {
        if ( jQuery ( this ).val () !== '' && $ ( this ).val () >= 0 )
            iSum = iSum + parseFloat ( $ ( this ).val () );
    } );
    $ ( '.other-transactions' ).val ( iSum );
    
    if ( parseFloat ( first_transaction ) - parseFloat ( iSum ) < 1 )
        $ ( '#multiple-transactions-btn' ).prop ( 'disabled', false );
    else
        $ ( '#multiple-transactions-btn' ).prop ( 'disabled', true );
    
    if ( parseFloat ( first_transaction ) - parseFloat ( iSum ) < 1 )
        console.log ( parseFloat ( first_transaction ) - parseFloat ( iSum ) );
}

function setTransactionPrice ( price ) {
    $ ( '.amount' ).val ( price );
}

function toggleJVTransactions ( value, searchVoucher = '' ) {
    let voucher = $ ( '#voucher' ).val ();
    
    if ( searchVoucher.length > 0 )
        voucher = searchVoucher;
    
    if ( voucher.length > 0 && voucher === 'jv' ) {
        if ( value === 'credit' ) {
            $ ( '#transaction-type-2-debit' ).prop ( 'checked', true );
            $ ( '#transaction-type-2-credit' ).prop ( 'disabled', true );
            
            $ ( '#transaction-type-2-debit' ).prop ( 'disabled', false );
            $ ( '#transaction-type-2-credit' ).prop ( 'checked', false );
            
            $ ( '.other-transactions-credit' ).prop ( 'disabled', false );
            $ ( '.other-transactions-debit' ).prop ( 'disabled', false );
            $ ( '.other-transactions-debit' ).prop ( 'checked', true );
            $ ( '.other-transactions-credit' ).prop ( 'disabled', true );
        }
        else if ( value === 'debit' ) {
            $ ( '#transaction-type-2-credit' ).prop ( 'checked', true );
            $ ( '#transaction-type-2-debit' ).prop ( 'disabled', true );
            
            $ ( '#transaction-type-2-credit' ).prop ( 'disabled', false );
            $ ( '#transaction-type-2-debit' ).prop ( 'checked', false );
            
            $ ( '.other-transactions-credit' ).prop ( 'disabled', false );
            $ ( '.other-transactions-debit' ).prop ( 'disabled', false );
            $ ( '.other-transactions-debit' ).prop ( 'disabled', true );
            $ ( '.other-transactions-credit' ).prop ( 'checked', true );
        }
    }
}

function toggleJVTransactionsAddMore ( value ) {
    let voucher = $ ( '#voucher' ).val ();
    
    if ( voucher.length > 0 && voucher === 'jv' ) {
        if ( value === 'credit' ) {
            $ ( '.other-transactions-credit' ).prop ( 'disabled', false );
            $ ( '.other-transactions-debit' ).prop ( 'disabled', false );
            $ ( '.other-transactions-debit' ).prop ( 'checked', true );
            $ ( '.other-transactions-credit' ).prop ( 'disabled', true );
        }
        else if ( value === 'debit' ) {
            $ ( '.other-transactions-credit' ).prop ( 'disabled', false );
            $ ( '.other-transactions-debit' ).prop ( 'disabled', false );
            $ ( '.other-transactions-debit' ).prop ( 'disabled', true );
            $ ( '.other-transactions-credit' ).prop ( 'checked', true );
        }
    }
}

function loadCustomerOrVendorDropdown ( account_head_id, route ) {
    let voucher = $ ( '#voucher' ).val ();
    if ( account_head_id.length > 0 && voucher !== 'jv' ) {
        ajaxSetup ();
        jQuery.ajax ( {
                          type   : 'GET',
                          url    : route,
                          data   : {
                              account_head_id
                          },
                          success: function ( response ) {
                              let $transactionDropdown = $ ( '#transaction-dropdown' );
                              $transactionDropdown.empty ();
                              $transactionDropdown.html ( response );
                              $ ( '.select2' ).select2 ();
                          },
                          error  : function ( xHR, exception ) {
                              ajaxErrors ( xHR, exception );
                          }
                      } )
    }
}

function downloadExcel ( title ) {
    // Get the HTML table
    let table = document.getElementById ( "excel-table" );
    
    // Convert the table to a sheet object
    let sheet = XLSX.utils.table_to_sheet ( table );
    
    // Create a workbook object
    let workbook = XLSX.utils.book_new ();
    
    // Add the sheet to the workbook
    XLSX.utils.book_append_sheet ( workbook, sheet, "Sheet1" );
    
    // Convert the workbook to a binary string
    let wbout = XLSX.write ( workbook, { bookType: "xlsx", type: "binary" } );
    
    // Create a Blob object from the binary string
    let blob = new Blob ( [ s2ab ( wbout ) ], { type: "application/octet-stream" } );
    
    // Create a download link and click it
    let url    = window.URL.createObjectURL ( blob );
    let a      = document.createElement ( "a" );
    a.href     = url;
    a.download = title + ".xlsx";
    a.click ();
    window.URL.revokeObjectURL ( url );
}

function s2ab ( s ) {
    let buf  = new ArrayBuffer ( s.length );
    let view = new Uint8Array ( buf );
    for ( let i = 0; i < s.length; i++ ) view[ i ] = s.charCodeAt ( i ) & 0xff;
    return buf;
}

function resourceDropZone () {
    const previewTemplate = '<div class="dz-preview dz-file-preview"><div class="dz-details"> <div class="dz-thumbnail"> <img data-dz-thumbnail> <span class="dz-nopreview">No preview</span> <div class="dz-success-mark"></div> <div class="dz-error-mark"></div> <div class="dz-error-message"><span data-dz-errormessage></span></div> <div class="progress"> <div class="progress-bar progress-bar-primary" role="progressbar" aria-valuemin="0" aria-valuemax="100" data-dz-uploadprogress></div> </div> </div> <div class="dz-filename" data-dz-name></div> <div class="dz-size" data-dz-size></div> </div> </div>';
    
    const resourceDropzone = document.querySelector ( '#resource-dropzone' );
    let $toasterContainer  = $ ( '#toast-container' );
    if ( resourceDropzone ) {
        let myDropzone = new Dropzone ( resourceDropzone, {
            previewTemplate: previewTemplate,
            maxFilesize    : 5120,
            addRemoveLinks : true,
            acceptedFiles  : 'image/jpg, image/jpeg, img/png, application/pdf',
            uploadMultiple : true,
            parallelUploads: 1,
            success        : function ( file, response, progressEvent ) {
                $ ( '#resource-dropzone' ).trigger ( 'reset' );
                $toasterContainer.removeClass ( 'd-none' );
                $ ( '.toast-message' ).html ( 'File Name: ' + file.name );
                setTimeout ( function () {
                    $toasterContainer.addClass ( 'd-none' );
                }, 2000 );
                myDropzone.removeFile ( file );
                fetch_lead_attachments ( response.route );
            },
            error          : function ( file, response ) {
                ajaxErrors ( response.error );
            }
        } );
    }
}

function load_lead_attachment_popup ( route ) {
    if ( route.length > 0 ) {
        ajaxSetup ();
        jQuery.ajax ( {
                          type   : 'GET',
                          url    : route,
                          success: function ( response ) {
                              let $ajaxContent = $ ( '#ajax-content' );
                              $ajaxContent.empty ();
                              $ajaxContent.html ( response );
                              $ ( '#addResourceContent' ).modal ( 'show' );
                              resourceDropZone ();
                          },
                          error  : function ( xHR, exception ) {
                              ajaxErrors ( xHR, exception );
                          }
                      } )
    }
}

function fetch_lead_attachments ( route ) {
    if ( route.length > 0 ) {
        ajaxSetup ();
        jQuery.ajax ( {
                          type   : 'GET',
                          url    : route,
                          success: function ( response ) {
                              let $attachments = $ ( '#attachments' );
                              $attachments.empty ();
                              $attachments.html ( response );
                          },
                          error  : function ( xHR, exception ) {
                              ajaxErrors ( xHR, exception );
                          }
                      } )
    }
}

function load_create_task_popup ( route ) {
    if ( route.length > 0 ) {
        ajaxSetup ();
        jQuery.ajax ( {
                          type   : 'GET',
                          url    : route,
                          success: function ( response ) {
                              let $ajaxContent = $ ( '#ajax-content' );
                              $ajaxContent.empty ();
                              $ajaxContent.html ( response );
                              $ ( '#addContactTask' ).modal ( 'show' );
                              $ ( '.flatpickr-basic' ).flatpickr ( { monthSelectorType: 'static' } );
                              $ ( ".chosen-select" ).chosen ();
                          },
                          error  : function ( xHR, exception ) {
                              ajaxErrors ( xHR, exception );
                          }
                      } )
    }
}

function load_edit_task_popup ( route ) {
    if ( route.length > 0 ) {
        ajaxSetup ();
        jQuery.ajax ( {
                          type   : 'GET',
                          url    : route,
                          success: function ( response ) {
                              let $ajaxContent = $ ( '#ajax-content' );
                              $ajaxContent.empty ();
                              $ajaxContent.html ( response );
                              $ ( '#editContactTask' ).modal ( 'show' );
                              $ ( '.flatpickr-basic' ).flatpickr ( { monthSelectorType: 'static' } );
                              $ ( ".chosen-select" ).chosen ();
                          },
                          error  : function ( xHR, exception ) {
                              ajaxErrors ( xHR, exception );
                          }
                      } )
    }
}

$ ( document ).on ( 'change', '#reminder', function () {
    let reminder     = $ ( this ).val ();
    let reminderDate = $ ( '.reminder-date' );
    let reminderVia  = $ ( '.reminder-via' );
    
    if ( reminder === '1' ) {
        reminderDate.removeClass ( 'd-none' );
        reminderVia.removeClass ( 'd-none' );
        
        reminderDate.prop ( 'required', true );
        reminderVia.prop ( 'required', true );
    }
    else {
        reminderDate.addClass ( 'd-none' );
        reminderVia.addClass ( 'd-none' );
        
        reminderDate.prop ( 'required', false );
        reminderVia.prop ( 'required', false );
    }
} );

function store_tasks ( e, route ) {
    e.preventDefault ();
    
    if ( route.length > 0 ) {
        ajaxSetup ();
        let formElement = document.getElementById ( 'ajaxForm' ); // Get the form element
        let formData    = new FormData ( formElement );
        
        jQuery.ajax ( {
                          type       : 'POST',
                          url        : route,
                          data       : formData,
                          processData: false,
                          contentType: false,
                          cache      : false,
                          success    : function ( response ) {
                              ajaxSuccess ( response.success );
                              $ ( '#ajaxForm' ).trigger ( 'reset' );
                              load_open_activities ( response.route );
                              reset_buttons ();
                          },
                          error      : function ( xHR, exception ) {
                              ajaxErrors ( xHR, exception );
                              reset_buttons ();
                          }
                      } )
    }
}

function update_task ( e, route ) {
    e.preventDefault ();
    
    if ( route.length > 0 ) {
        ajaxSetup ();
        let formElement = document.getElementById ( 'ajaxForm' ); // Get the form element
        let formData    = new FormData ( formElement );
        
        jQuery.ajax ( {
                          type       : 'POST',
                          url        : route,
                          data       : formData,
                          processData: false,
                          contentType: false,
                          cache      : false,
                          success    : function ( response ) {
                              ajaxSuccess ( response.success );
                              load_open_activities ( response.route );
                              reset_buttons ();
                          },
                          error      : function ( xHR, exception ) {
                              ajaxErrors ( xHR, exception );
                              reset_buttons ();
                          }
                      } )
    }
}

function load_create_meeting_popup ( route ) {
    if ( route.length > 0 ) {
        ajaxSetup ();
        jQuery.ajax ( {
                          type   : 'GET',
                          url    : route,
                          success: function ( response ) {
                              let $ajaxContent = $ ( '#ajax-content' );
                              $ajaxContent.empty ();
                              $ajaxContent.html ( response );
                              $ ( '#addContactMeeting' ).modal ( 'show' );
                              $ ( '.flatpickr-basic' ).flatpickr ( { monthSelectorType: 'static' } );
                              $ ( ".chosen-select" ).chosen ();
                          },
                          error  : function ( xHR, exception ) {
                              ajaxErrors ( xHR, exception );
                          }
                      } )
    }
}

function store_meetings ( e, route ) {
    e.preventDefault ();
    
    if ( route.length > 0 ) {
        ajaxSetup ();
        let formElement = document.getElementById ( 'ajaxForm' ); // Get the form element
        let formData    = new FormData ( formElement );
        
        jQuery.ajax ( {
                          type       : 'POST',
                          url        : route,
                          data       : formData,
                          processData: false,
                          contentType: false,
                          cache      : false,
                          success    : function ( response ) {
                              ajaxSuccess ( response.success );
                              $ ( '#ajaxForm' ).trigger ( 'reset' );
                              load_open_activities ( response.route );
                              reset_buttons ();
                          },
                          error      : function ( xHR, exception ) {
                              ajaxErrors ( xHR, exception );
                              reset_buttons ();
                          }
                      } )
    }
}

function update_meetings ( e, route ) {
    e.preventDefault ();
    
    if ( route.length > 0 ) {
        ajaxSetup ();
        let formElement = document.getElementById ( 'ajaxForm' ); // Get the form element
        let formData    = new FormData ( formElement );
        
        jQuery.ajax ( {
                          type       : 'POST',
                          url        : route,
                          data       : formData,
                          processData: false,
                          contentType: false,
                          cache      : false,
                          success    : function ( response ) {
                              ajaxSuccess ( response.success );
                              load_open_activities ( response.route );
                              reset_buttons ();
                          },
                          error      : function ( xHR, exception ) {
                              ajaxErrors ( xHR, exception );
                              reset_buttons ();
                          }
                      } )
    }
}

function load_edit_meeting_popup ( route ) {
    if ( route.length > 0 ) {
        ajaxSetup ();
        jQuery.ajax ( {
                          type   : 'GET',
                          url    : route,
                          success: function ( response ) {
                              let $ajaxContent = $ ( '#ajax-content' );
                              $ajaxContent.empty ();
                              $ajaxContent.html ( response );
                              $ ( '#editContactMeeting' ).modal ( 'show' );
                              $ ( '.flatpickr-basic' ).flatpickr ( { monthSelectorType: 'static' } );
                              $ ( ".chosen-select" ).chosen ();
                          },
                          error  : function ( xHR, exception ) {
                              ajaxErrors ( xHR, exception );
                          }
                      } )
    }
}

function load_create_call_popup ( route ) {
    if ( route.length > 0 ) {
        ajaxSetup ();
        jQuery.ajax ( {
                          type   : 'GET',
                          url    : route,
                          success: function ( response ) {
                              let $ajaxContent = $ ( '#ajax-content' );
                              $ajaxContent.empty ();
                              $ajaxContent.html ( response );
                              $ ( '#addContactCall' ).modal ( 'show' );
                              $ ( '.flatpickr-basic' ).flatpickr ( { monthSelectorType: 'static' } );
                              $ ( ".chosen-select" ).chosen ();
                              reset_buttons ();
                          },
                          error  : function ( xHR, exception ) {
                              ajaxErrors ( xHR, exception );
                              reset_buttons ();
                          }
                      } )
    }
}

function store_calls ( e, route ) {
    e.preventDefault ();
    
    if ( route.length > 0 ) {
        ajaxSetup ();
        let formElement = document.getElementById ( 'ajaxForm' ); // Get the form element
        let formData    = new FormData ( formElement );
        
        jQuery.ajax ( {
                          type       : 'POST',
                          url        : route,
                          data       : formData,
                          processData: false,
                          contentType: false,
                          cache      : false,
                          success    : function ( response ) {
                              ajaxSuccess ( response.success );
                              $ ( '#ajaxForm' ).trigger ( 'reset' );
                              reset_buttons ();
                              load_open_activities ( response.route );
                          },
                          error      : function ( xHR, exception ) {
                              ajaxErrors ( xHR, exception );
                              reset_buttons ();
                          }
                      } )
    }
}

function load_edit_call_popup ( route ) {
    if ( route.length > 0 ) {
        ajaxSetup ();
        jQuery.ajax ( {
                          type   : 'GET',
                          url    : route,
                          success: function ( response ) {
                              let $ajaxContent = $ ( '#ajax-content' );
                              $ajaxContent.empty ();
                              $ajaxContent.html ( response );
                              $ ( '#editContactCall' ).modal ( 'show' );
                              $ ( '.flatpickr-basic' ).flatpickr ( { monthSelectorType: 'static' } );
                              $ ( ".chosen-select" ).chosen ();
                              reset_buttons ();
                          },
                          error  : function ( xHR, exception ) {
                              ajaxErrors ( xHR, exception );
                              reset_buttons ();
                          }
                      } )
    }
}

function update_calls ( e, route ) {
    e.preventDefault ();
    
    if ( route.length > 0 ) {
        ajaxSetup ();
        let formElement = document.getElementById ( 'ajaxForm' ); // Get the form element
        let formData    = new FormData ( formElement );
        
        jQuery.ajax ( {
                          type       : 'POST',
                          url        : route,
                          data       : formData,
                          processData: false,
                          contentType: false,
                          cache      : false,
                          success    : function ( response ) {
                              ajaxSuccess ( response.success );
                              reset_buttons ();
                              load_open_activities ( response.route );
                          },
                          error      : function ( xHR, exception ) {
                              ajaxErrors ( xHR, exception );
                              reset_buttons ();
                          }
                      } )
    }
}

function load_open_activities ( route ) {
    if ( route.length > 0 ) {
        ajaxSetup ();
        
        jQuery.ajax ( {
                          type   : 'GET',
                          url    : route,
                          success: function ( response ) {
                              $ ( '#loadOpenActivities' ).html ( response );
                          },
                          error  : function ( xHR, exception ) {
                              ajaxErrors ( xHR, exception );
                          }
                      } )
    }
}

function load_closed_activities ( route ) {
    if ( route.length > 0 ) {
        ajaxSetup ();
        
        jQuery.ajax ( {
                          type   : 'GET',
                          url    : route,
                          success: function ( response ) {
                              $ ( '#loadClosedActivities' ).html ( response );
                          },
                          error  : function ( xHR, exception ) {
                              ajaxErrors ( xHR, exception );
                          }
                      } )
    }
}

function load_notes ( route ) {
    if ( route.length > 0 ) {
        ajaxSetup ();
        
        jQuery.ajax ( {
                          type   : 'GET',
                          url    : route,
                          success: function ( response ) {
                              $ ( '#loadNotes' ).html ( response );
                          },
                          error  : function ( xHR, exception ) {
                              ajaxErrors ( xHR, exception );
                          }
                      } )
    }
}

function load_create_notes_popup ( route ) {
    if ( route.length > 0 ) {
        ajaxSetup ();
        jQuery.ajax ( {
                          type   : 'GET',
                          url    : route,
                          success: function ( response ) {
                              let $ajaxContent = $ ( '#ajax-content' );
                              $ajaxContent.empty ();
                              $ajaxContent.html ( response );
                              $ ( '#addContactNote' ).modal ( 'show' );
                              reset_buttons ();
                          },
                          error  : function ( xHR, exception ) {
                              ajaxErrors ( xHR, exception );
                              reset_buttons ();
                          }
                      } )
    }
}

function store_notes ( e, route ) {
    e.preventDefault ();
    
    if ( route.length > 0 ) {
        ajaxSetup ();
        let formElement = document.getElementById ( 'ajaxForm' ); // Get the form element
        let formData    = new FormData ( formElement );
        
        jQuery.ajax ( {
                          type       : 'POST',
                          url        : route,
                          data       : formData,
                          processData: false,
                          contentType: false,
                          cache      : false,
                          success    : function ( response ) {
                              ajaxSuccess ( response.success );
                              $ ( '#ajaxForm' ).trigger ( 'reset' );
                              load_notes ( response.route );
                              reset_buttons ();
                          },
                          error      : function ( xHR, exception ) {
                              ajaxErrors ( xHR, exception );
                              reset_buttons ();
                          }
                      } )
    }
}

function load_edit_notes_popup ( route ) {
    if ( route.length > 0 ) {
        ajaxSetup ();
        jQuery.ajax ( {
                          type   : 'GET',
                          url    : route,
                          success: function ( response ) {
                              let $ajaxContent = $ ( '#ajax-content' );
                              $ajaxContent.empty ();
                              $ajaxContent.html ( response );
                              $ ( '#editContactNote' ).modal ( 'show' );
                              reset_buttons ();
                          },
                          error  : function ( xHR, exception ) {
                              ajaxErrors ( xHR, exception );
                              reset_buttons ();
                          }
                      } )
    }
}

function update_contact_note ( e, route ) {
    e.preventDefault ();
    
    if ( route.length > 0 ) {
        ajaxSetup ();
        let formElement = document.getElementById ( 'ajaxForm' ); // Get the form element
        let formData    = new FormData ( formElement );
        
        jQuery.ajax ( {
                          type       : 'POST',
                          url        : route,
                          data       : formData,
                          processData: false,
                          contentType: false,
                          cache      : false,
                          success    : function ( response ) {
                              ajaxSuccess ( response.success );
                              load_notes ( response.route );
                              reset_buttons ();
                          },
                          error      : function ( xHR, exception ) {
                              ajaxErrors ( xHR, exception );
                              reset_buttons ();
                          }
                      } )
    }
}

function load_cities_by_country ( country_id, route ) {
    if ( parseInt ( country_id ) > 0 && route.length > 0 ) {
        ajaxSetup ();
        
        jQuery.ajax ( {
                          type   : 'GET',
                          url    : route,
                          data   : {
                              country_id
                          },
                          success: function ( response ) {
                              let $city = $ ( '#city' );
                              $city.html ( response );
                              $city.trigger ( "chosen:updated" );
                          },
                          error  : function ( xHR, exception ) {
                              ajaxErrors ( xHR, exception );
                          }
                      } )
    }
}

function loadDealsPopup ( route ) {
    if ( route.length > 0 ) {
        ajaxSetup ();
        
        jQuery.ajax ( {
                          type   : 'GET',
                          url    : route,
                          success: function ( response ) {
                              $ ( '#ajaxContent' ).html ( response );
                              $ ( '#modal' ).modal ( 'show' );
                              $ ( '.chosen-select' ).chosen ();
                          },
                          error  : function ( xHR, exception ) {
                              ajaxErrors ( xHR, exception );
                          }
                      } )
    }
}

function get_deals_by_project ( project_id, route, contact_id = 0 ) {
    if ( route.length > 0 ) {
        ajaxSetup ();
        
        jQuery.ajax ( {
                          type   : 'GET',
                          url    : route,
                          data   : {
                              project_id,
                              contact_id
                          },
                          success: function ( response ) {
                              let $deal = $ ( '#deal' );
                              $deal.html ( response );
                              $deal.trigger ( "chosen:updated" );
                          },
                          error  : function ( xHR, exception ) {
                              ajaxErrors ( xHR, exception );
                          }
                      } )
    }
}

function load_deals ( route ) {
    if ( route.length > 0 ) {
        ajaxSetup ();
        
        jQuery.ajax ( {
                          type   : 'GET',
                          url    : route,
                          success: function ( response ) {
                              $ ( '#loadDeals' ).html ( response );
                          },
                          error  : function ( xHR, exception ) {
                              ajaxErrors ( xHR, exception );
                          }
                      } )
    }
}

function load_add_more_deals_popup ( route ) {
    if ( route.length > 0 ) {
        ajaxSetup ();
        jQuery.ajax ( {
                          type   : 'GET',
                          url    : route,
                          success: function ( response ) {
                              let $ajaxContent = $ ( '#ajax-content' );
                              $ajaxContent.empty ();
                              $ajaxContent.html ( response );
                              $ ( '#modal' ).modal ( 'show' );
                              $ ( ".chosen-select" ).chosen ();
                              reset_buttons ();
                          },
                          error  : function ( xHR, exception ) {
                              ajaxErrors ( xHR, exception );
                              reset_buttons ();
                          }
                      } )
    }
}

function load_add_event_popup ( date, route ) {
    ajaxSetup ();
    
    $.ajax ( {
                 type   : 'GET',
                 url    : route,
                 data   : {
                     date
                 },
                 success: function ( response ) {
                     let eventContent = $ ( '#ajaxContent' );
                     eventContent.empty ();
                     eventContent.html ( response );
                     $ ( '#modal' ).modal ( 'show' );
                     $ ( '.select2' ).select2 ( { dropdownParent: $ ( '#modal' ) } );
                     $ ( '.flatpickr-basic' ).flatpickr ( { monthSelectorType: 'static' } );
                 },
                 error  : function ( xHR, exception ) {
                     ajaxErrors ( xHR, exception );
                 }
             } )
}

function load_edit_event_popup ( route ) {
    ajaxSetup ();
    
    $.ajax ( {
                 type   : 'GET',
                 url    : route,
                 success: function ( response ) {
                     let eventContent = $ ( '#ajaxContent' );
                     eventContent.empty ();
                     eventContent.html ( response );
                     $ ( '#modal' ).modal ( 'show' );
                     $ ( '.select2' ).select2 ( { dropdownParent: $ ( '#modal' ) } );
                     $ ( '.flatpickr-basic' ).flatpickr ( { monthSelectorType: 'static' } );
                 },
                 error  : function ( xHR, exception ) {
                     ajaxErrors ( xHR, exception );
                 }
             } )
}

function update_event_date_on_drag_drop ( event_id, start_date, end_date ) {
    ajaxSetup ();
    
    $.ajax ( {
                 type   : 'POST',
                 url    : '/update-event-date-on-drag',
                 data   : {
                     event_id,
                     start_date,
                     end_date
                 },
                 success: function ( response ) {
                     ajaxSuccess ( response.message, '', false );
                     calendar.refetchEvents ();
                 },
                 error  : function ( xHR, exception ) {
                     ajaxErrors ( xHR, exception );
                     info.revert ();
                 }
             } )
}

$ ( '#check-all' ).on ( 'click', function () {
    $ ( '#privileges input:checkbox' ).not ( this ).prop ( 'checked', this.checked );
} );

$ ( "#search-privileges" ).on ( "keyup", function () {
    let value = this.value.toLowerCase ().trim ();
    
    $ ( "table tr" ).each ( function ( index ) {
        if ( !index ) return;
        $ ( this ).find ( "td" ).each ( function () {
            let id        = $ ( this ).text ().toLowerCase ().trim ();
            let not_found = ( id.indexOf ( value ) === -1 );
            $ ( this ).closest ( 'tr' ).toggle ( !not_found );
            return not_found;
        } );
    } );
} );

function loadBulkFlightDetailsPopup ( route ) {
    ajaxSetup ();
    
    $.ajax ( {
                 type   : 'GET',
                 url    : route,
                 data   : {
                     candidates: $ ( '#selected-candidates' ).val (),
                 },
                 success: function ( response ) {
                     let $flightDetailModal = $ ( '#flightDetailModal' );
                     $ ( '#ajaxContent' ).html ( response );
                     $ ( '#flightDetailModal' ).modal ( 'show' );
                     $ ( '.select2' ).select2 ( {
                                                    dropdownParent: $ ( '#flightDetailModal' )
                                                } );
                     $ ( '.flatpickr-basic' ).flatpickr ();
                 },
                 error  : function ( xHR, exception ) {
                     ajaxErrors ( xHR, exception );
                 }
             } )
}

function addMoreRequisitionQuota ( route ) {
    ajaxSetup ();
    
    $.ajax ( {
                 type   : 'GET',
                 url    : route,
                 success: function ( response ) {
                     $ ( '#addMore' ).append ( response );
                     $ ( '.chosen-select' ).chosen ();
                 },
                 error  : function ( xHR, exception ) {
                     ajaxErrors ( xHR, exception );
                 }
             } )
}

function loadCompanyRequisitions ( company_id, route ) {
    ajaxSetup ();
    
    $.ajax ( {
                 type   : 'GET',
                 url    : route,
                 data   : {
                     company_id
                 },
                 success: function ( response ) {
                     let $companyRequisitionJob = $ ( '#company-requisition-job' );
                     $companyRequisitionJob.html ( response );
                     $companyRequisitionJob.trigger ( "chosen:updated" );
                 },
                 error  : function ( xHR, exception ) {
                     ajaxErrors ( xHR, exception );
                 }
             } )
}

function get_payable_count ( route ) {
    ajaxSetup ();
    $.ajax ( {
                 type   : 'GET',
                 url    : route,
                 success: function ( response ) {
                     $ ( '.payable-count' ).html ( response );
                 },
                 error  : function ( xHR, exception ) {
                     // ajaxErrors ( xHR, exception );
                 }
             } )
}

function get_receivable_count ( route ) {
    ajaxSetup ();
    $.ajax ( {
                 type   : 'GET',
                 url    : route,
                 success: function ( response ) {
                     $ ( '.receivable-count' ).html ( response );
                 },
                 error  : function ( xHR, exception ) {
                     // ajaxErrors ( xHR, exception );
                 }
             } )
}

function ticketPrice ( price ) {
    if ( parseFloat ( price ) >= 0 )
        $ ( '.price' ).val ( parseFloat ( price ) );
    else
        $ ( '.price' ).val ( 0 );
}

function validateInput ( inputElement ) {
    return true;
    // Check if the input contains only alphabets
    // if ( /^[A-Za-z\s]+$/.test ( inputElement.value ) ) {
    //     inputElement.setCustomValidity ( '' );
    // }
    // else {
    //     inputElement.setCustomValidity ( 'Please enter only alphabets.' );
    // }
}

let restrictCount = 0;

function restrictDemand ( quota, row ) {
    let used = $ ( '.used-' + row ).val ();
    
    if ( parseFloat ( quota ) < parseFloat ( used ) ) {
        $ ( '.quota-' + row ).css ( 'border', '1px solid #FF0000' );
        $ ( '.data-submit' ).prop ( 'disabled', true );
        restrictCount++;
    }
    else {
        $ ( '.quota-' + row ).css ( 'border', '1px solid #dbdade' );
        restrictCount > 0 ? restrictCount-- : 0;
    }
    
    if ( parseInt ( restrictCount ) < 1 )
        $ ( '.data-submit' ).prop ( 'disabled', false );
}

function get_test_income_count ( route ) {
    ajaxSetup ();
    $.ajax ( {
                 type   : 'GET',
                 url    : route,
                 success: function ( response ) {
                     $ ( '.income-from-test' ).html ( response );
                 },
                 error  : function ( xHR, exception ) {
                     // ajaxErrors ( xHR, exception );
                 }
             } )
}

function get_medical_income_count ( route ) {
    ajaxSetup ();
    $.ajax ( {
                 type   : 'GET',
                 url    : route,
                 success: function ( response ) {
                     $ ( '.income-from-medical' ).html ( response );
                 },
                 error  : function ( xHR, exception ) {
                     // ajaxErrors ( xHR, exception );
                 }
             } )
}

function get_candidate_income_count ( route ) {
    ajaxSetup ();
    $.ajax ( {
                 type   : 'GET',
                 url    : route,
                 success: function ( response ) {
                     $ ( '.income-from-candidates' ).html ( response );
                 },
                 error  : function ( xHR, exception ) {
                     // ajaxErrors ( xHR, exception );
                 }
             } )
}

function calculateAge ( dob ) {
    let currentDate         = new Date ();
    let birthDate           = new Date ( dob );
    let age                 = currentDate.getFullYear () - birthDate.getFullYear ();
    let hasBirthdayOccurred = ( currentDate.getMonth () > birthDate.getMonth () ) ||
                              ( currentDate.getMonth () === birthDate.getMonth () && currentDate.getDate () >= birthDate.getDate () );
    
    if ( !hasBirthdayOccurred ) {
        age--;
    }
    
    $ ( '#age' ).val ( parseInt ( age ) );
}

function loadBulkVisaDetailsPopup ( route ) {
    ajaxSetup ();
    
    $.ajax ( {
                 type   : 'GET',
                 url    : route,
                 data   : {
                     candidates: $ ( '#selected-candidates' ).val (),
                 },
                 success: function ( response ) {
                     $ ( '#ajaxContent' ).html ( response );
                     $ ( '#candidateStatusModal' ).modal ( 'show' );
                     $ ( '.select2' ).select2 ( {
                                                    dropdownParent: $ ( '#candidateStatusModal' )
                                                } );
                 },
                 error  : function ( xHR, exception ) {
                     ajaxErrors ( xHR, exception );
                 }
             } )
}

$ ( document ).on ( 'change', '#free-candidate', function () {
    let paymentMethod = $ ( '#payment-method' );
    let transactionNO = $ ( '#transaction-no' );
    if ( $ ( this ).is ( ':checked' ) ) {
        paymentMethod.prop ( 'disabled', true );
        transactionNO.prop ( 'disabled', true );
    }
    else {
        paymentMethod.prop ( 'disabled', false );
        transactionNO.prop ( 'disabled', false );
    }
} );