@extends('partials.app')
@section('title', 'Lead List')
@section('container')
    <div class="container">

        <div class="page-inner">
            <div class="page-header">
                <h4 class="page-title">Dashboard</h4>
                <ul class="breadcrumbs">
                    <li class="nav-home">
                        <a href="{{ route('dashboard') }}">
                            <i class="icon-home"></i>
                        </a>
                    </li>
                    <li class="separator">
                        <i class="icon-arrow-right"></i>
                    </li>
                    <li class="nav-item">
                        <a href="#">Leads</a>
                    </li>

                </ul>
            </div>
        </div>

        <div class="card mx-4">
            <div class="card-header">
                @include('status')
            </div>
            <div class="card-body">
                <h4 class="card-title">Leads List</h4>

                {{-- <input type="checkbox" checked data-toggle="toggle" data-width="100" data-height="75" data-onlabel="Active" data-offlabel="Block" data-onstyle="success" data-offstyle="danger"> --}}


                <div class="table-responsive">
                    <table class="table table-striped table-bordered table-hover text-center" id="leadListTable"
                        style="width: 100%">
                        <thead>
                            <tr>
                                <th class="text-center">#</th>
                                <th class="text-center">Name</th>
                                <th class="text-center">Email</th>
                                <th class="text-center">Mobile</th>
                                <th class="text-center">Quotes</th>
                                <th class="text-center">Gst Number</th>
                                <th class="text-center">Remarks</th>
                                <th class="text-center">Action</th>
                            </tr>
                        </thead>
                        <tbody>

                        </tbody>


                    </table>
                </div>
            </div>
        </div>
    </div>


    {{-- Mail Model --}}

    <div class="modal fade" id="mailModal" tabindex="-1" aria-labelledby="mailModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <form action="{{ route('admin_mail_send') }}" id="mailSendForm" method="post"
                    enctype="multipart/form-data">
                    @csrf
                    <div class="modal-header">
                        <h5 class="modal-title" id="mailModalLabel">Send Mail</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <input type="hidden" name="qid" id="qid">
                        <div class="mb-3">
                            <label for="recipient_email" class="col-form-label">Recipient Email:</label>
                            <input type="text" class="form-control" name="recipient_email" id="recipient_email" readonly
                                required>
                        </div>
                        <div class="mb-3">
                            <label for="message" class="col-form-label">Message:</label>
                            <textarea class="form-control" name="message" placeholder="Enter message" required
                                style="min-height: 150px; max-height: 400px; width: 100%; resize: vertical;"></textarea>
                        </div>
                        <div class="mb-3">
                            <label for="attachment" class="col-form-label">Attachment: <span class="text-danger">(Max 5 MB
                                    only) (Select only .pdf, .xls, .xlsx, .doc, .docx, .jpeg, .jpg, .png,
                                    .gif)</span></label>
                            <input type="file" class="form-control" name="attachment" id="attachment"
                                accept=".pdf, .xls, .xlsx, .doc, .docx, .jpeg, .jpg, .png, .gif" />
                            <span id="file-error" style="color: red; display: none;">Invalid file type. Please select a
                                valid file (PDF, Excel, Word, Image).</span>
                        </div>

                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                        <button type="submit" id="submit_btn" class="btn btn-primary">Send message</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection


@push('script')
    <script>
        $(document).ready(function() {
            var table = $('#leadListTable').DataTable({
                processing: true,
                serverSide: true,
                responsive: true,
                // order: [
                //     [0, "desc"]
                // ],
                ajax: {
                    url: "{{ route('admin_lead_list') }}",
                    type: 'GET'
                },
                columns: [{
                        data: 'id',
                        name: 'id'
                    },
                    {
                        data: 'name',
                        name: 'name'
                    },
                    {
                        data: 'email',
                        name: 'email'
                    },
                    {
                        data: 'mobile',
                        name: 'mobile'
                    },
                    {
                        data: 'quotes',
                        name: 'quotes'
                    }, {
                        data: 'gst_number',
                        name: 'gst_number'
                    }, {
                        data: 'remarks',
                        name: 'remarks'
                    },
                    {
                        data: 'actions',
                        name: 'actions',
                        orderable: false,
                        searchable: false
                    },
                ]
            });
        });
        $(document).on("click", ".sendMailBtn", function(e) {
            e.preventDefault();
            let email = $(this).attr("data-email")
            let quote_id = $(this).attr("data-qid")
            $("#recipient_email").val(email)
            $("#qid").val(quote_id)
            $("#mailModal").modal("show")
        })

        // File Type Error
        $(document).ready(function() {
            $('#attachment').on('change', function() {
                var allowedExtensions = /(\.pdf|\.xls|\.xlsx|\.doc|\.docx|\.jpeg|\.jpg|\.png|\.gif)$/i;
                var fileInput = $(this);
                var filePath = fileInput.val();

                // Clear any previous error
                $('#file-error').hide();

                // Check if file extension is valid
                if (!allowedExtensions.exec(filePath)) {
                    $('#file-error').show(); // Show error message
                    fileInput.val(''); // Clear the file input
                    return false;
                } else {
                    $('#file-error').hide(); // Hide error if valid file selected
                }
            });


            // Mail Send
            $("#mailSendForm").on("submit", function(e) {
                // Disable the submit button
                $("#submit_btn").attr("disabled", true).text("Sending..."); // Optionally update button text
            });
        });
    </script>
@endpush
