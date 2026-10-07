<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Email Dispatch Center</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
</head>
<body class="bg-light">

<div class="container py-5">

    <!-- Header -->
    <div class="d-flex align-items-center justify-content-between flex-wrap gap-3 mb-4 pb-3 border-bottom">
        <div class="d-flex align-items-center gap-3">
            <!-- <div class="bg-dark text-white rounded-3 d-flex align-items-center justify-content-center" style="width:46px;height:46px;font-size:20px;">
                ✉️
            </div> -->
            <div>
                <h1 class="h4 mb-0 fw-bold">Email Sender</h1>
                
            </div>
        </div>
        <div class="d-flex gap-2">
            <button class="btn btn-warning " onclick="openModal('cron')">
                <i class="fas fa-plus"></i> Cron Job
            </button>
            <button class="btn btn-info  text-white" onclick="openModal('queue')">
                <i class="fas fa-plus"></i> Queue Job
            </button>
        </div>
    </div>

    <!-- Flash messages -->
    @if(session('success'))
    <div class="alert alert-success alert-dismissible fade show d-flex align-items-center gap-2" role="alert">
        <i class="bi bi-check-circle-fill"></i>
        {{ session('success') }}
        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
    </div>
    @endif

    @if($errors->any())
    <div class="alert alert-danger alert-dismissible fade show d-flex align-items-center gap-2" role="alert">
        <i class="bi bi-exclamation-circle-fill"></i>
        {{ $errors->first() }}
        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
    </div>
    @endif

    <!-- Table -->
    <!-- <p class="text-uppercase text-muted fw-semibold mb-2" style="font-size:.72rem;letter-spacing:.08em;">Email Dispatch Log</p> -->

    <div class="card shadow-sm">
        @if($logs->isEmpty())
        <div class="card-body text-center py-5 text-muted">
            <div class="bg-light border rounded-3 d-inline-flex align-items-center justify-content-center mb-3" style="width:56px;height:56px;font-size:24px;">✉️</div>
            <p class="mb-0">No Data Found.</p>
        </div>
        @else
        <div class="table-responsive">
            <table class="table table-hover table-bordered align-middle mb-0">
                <thead class="table-primary">
                    <tr>
                        <th class="text-uppercase text-muted fw-semibold" style="font-size:.7rem;letter-spacing:.07em;">S.no</th>
                        <th class="text-uppercase text-muted fw-semibold" style="font-size:.7rem;letter-spacing:.07em;">Type</th>
                        <th class="text-uppercase text-muted fw-semibold" style="font-size:.7rem;letter-spacing:.07em;">Subject</th>
                        <th class="text-uppercase text-muted fw-semibold" style="font-size:.7rem;letter-spacing:.07em;">Email Content</th>
                        <th class="text-uppercase text-muted fw-semibold" style="font-size:.7rem;letter-spacing:.07em;">Email Addresses</th>
                        <th class="text-uppercase text-muted fw-semibold" style="font-size:.7rem;letter-spacing:.07em;">Status</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($logs as $log)
                    <tr>
                        <td>{{ $loop->iteration }}</td>
                        <td>
                            @if($log->type === 'cron')
                                <span class="badge bg-warning text-dark">
                                    Cron
                                </span>
                            @else
                                <span class="badge bg-info text-white">
                                    Queue
                                </span>
                            @endif
                        </td>
                        <td class="fw-semibold">{{ $log->subject }}</td>
                        <td class="text-muted" style="min-width:300px; white-space:pre-wrap;">
    {{ $log->email_content }}
</td>
                        <td class="text-muted" style="max-width:200px;">
                            {!! str_replace(',', '<br>', e($log->email_addresses)) !!}
                        </td>
                        <td>
                            @if($log->status === 'completed')
                                <span class="badge bg-success">
                                    <i class="bi bi-check-lg me-1"></i>Completed
                                </span>
                            @else
                                <span class="badge bg-warning text-dark">
                                    <i class="bi bi-hourglass-split me-1"></i>
                                    Pending
                                    <span class="fw-normal">({{ $log->sent_count }}/{{ $log->total_sends }})</span>
                                </span>
                            @endif
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
        @endif
    </div>

</div>

<!-- Modal -->
<div class="modal fade" id="emailModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">

            <div class="modal-header">
                <div>
                    <span id="modalTag" class="badge mb-1"></span>
                    <h5 class="modal-title mb-0" id="modalTitle"></h5>
                    <small class="text-muted" id="modalSubtitle"></small>
                </div>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>

            <div class="modal-body">
                <form method="POST" action="{{ route('email-sender.send') }}" id="emailForm">
                    @csrf
                    <input type="hidden" name="type" id="jobType">

                    <div class="mb-3">
                        <label for="subject" class="form-label fw-semibold">Subject</label>
                        <input type="text" class="form-control @error('subject') is-invalid @enderror"
                               id="subject" name="subject"
                               placeholder="Subject"
                               value="{{ old('subject') }}" required>
                        @error('subject')
                        <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label for="email_content" class="form-label fw-semibold">Email Content</label>
                        <textarea class="form-control @error('email_content') is-invalid @enderror"
                                  id="email_content" name="email_content"
                                  placeholder="Write your email body here…"
                                  rows="4" required>{{ old('email_content') }}</textarea>
                        @error('email_content')
                        <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label for="email_addresses" class="form-label fw-semibold">Email Addresses</label>
                        <textarea class="form-control @error('email_addresses') is-invalid @enderror"
                                  id="email_addresses" name="email_addresses"
                                  placeholder="Email Address"
                                  rows="3" required>{{ old('email_addresses') }}</textarea>
                        <!-- <div class="form-text">Separate multiple addresses with commas or new lines.</div> -->
                        @error('email_addresses')
                        <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </form>
            </div>

            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                <button type="submit" form="emailForm" class="btn" id="submitBtn">
                     Send Email
                </button>
            </div>

        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
<script>
    const emailModal = new bootstrap.Modal(document.getElementById('emailModal'));

    const config = {
        cron: {
            tag: 'Cron Job',
            tagClass: 'bg-warning text-dark',
            title: 'Send Email By Cron Job',
            subtitle: '',
            btnClass: 'btn-warning',
        },
        queue: {
            tag: 'Queue Job',
            tagClass: 'bg-info text-white',
            title: 'Send Email By Queue Job',
            subtitle: '',
            btnClass: 'btn-info text-white',
        },
    };

    function openModal(type) {
        const c = config[type];
        document.getElementById('jobType').value = type;

        const tag = document.getElementById('modalTag');
        tag.textContent = c.tag;
        tag.className = `badge mb-1 ${c.tagClass}`;

        document.getElementById('modalTitle').textContent    = c.title;
        document.getElementById('modalSubtitle').textContent = c.subtitle;

        const btn = document.getElementById('submitBtn');
        btn.className = `btn ${c.btnClass}`;

        emailModal.show();
        setTimeout(() => document.getElementById('subject').focus(), 300);
    }

    @if($errors->any() && old('type'))
    openModal('{{ old('type') }}');
    @endif

    const flash = document.querySelector('.alert');
    if (flash) setTimeout(() => {
        const bsAlert = bootstrap.Alert.getOrCreateInstance(flash);
        bsAlert.close();
    }, 5000);
</script>

</body>
</html>