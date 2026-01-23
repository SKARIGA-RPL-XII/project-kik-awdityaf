<!-- Page Heading -->
<div class="d-sm-flex align-items-center justify-content-between mb-4">
    <h1 class="h3 mb-0 text-gray-800">
        <i class="fas fa-user-check text-success mr-2"></i>Gym Attendance
    </h1>
    <div>
        <a href="<?= base_url('gym/manual_checkin'); ?>" class="btn btn-sm btn-success shadow-sm mr-2">
            <i class="fas fa-user-plus fa-sm text-white-50"></i> Manual Check-in
        </a>
        <button class="btn btn-sm btn-info shadow-sm mr-2" onclick="refreshAttendance()">
            <i class="fas fa-sync fa-sm text-white-50"></i> Refresh
        </button>
        <a href="<?= base_url('gym/attendance_history'); ?>" class="btn btn-sm btn-secondary shadow-sm">
            <i class="fas fa-history fa-sm text-white-50"></i> View History
        </a>
    </div>
</div>

<!-- Statistics Cards -->
<div class="row mb-4">
    <div class="col-xl-3 col-md-6 mb-4">
        <div class="card border-left-success shadow h-100 py-2">
            <div class="card-body">
                <div class="row no-gutters align-items-center">
                    <div class="col mr-2">
                        <div class="text-xs font-weight-bold text-success text-uppercase mb-1">
                            Today's Attendance</div>
                        <div class="h5 mb-0 font-weight-bold text-gray-800">
                            <?= isset($attendance_stats['today']) ? $attendance_stats['today'] : 0; ?>
                        </div>
                    </div>
                    <div class="col-auto">
                        <i class="fas fa-calendar-day fa-2x text-gray-300"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="col-xl-3 col-md-6 mb-4">
        <div class="card border-left-info shadow h-100 py-2">
            <div class="card-body">
                <div class="row no-gutters align-items-center">
                    <div class="col mr-2">
                        <div class="text-xs font-weight-bold text-info text-uppercase mb-1">
                            Currently In Gym</div>
                        <div class="h5 mb-0 font-weight-bold text-gray-800">
                            <?= isset($attendance_stats['currently_in_gym']) ? $attendance_stats['currently_in_gym'] : 0; ?>
                        </div>
                    </div>
                    <div class="col-auto">
                        <i class="fas fa-users fa-2x text-gray-300"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="col-xl-3 col-md-6 mb-4">
        <div class="card border-left-warning shadow h-100 py-2">
            <div class="card-body">
                <div class="row no-gutters align-items-center">
                    <div class="col mr-2">
                        <div class="text-xs font-weight-bold text-warning text-uppercase mb-1">
                            This Month</div>
                        <div class="h5 mb-0 font-weight-bold text-gray-800">
                            <?= isset($attendance_stats['this_month']) ? $attendance_stats['this_month'] : 0; ?>
                        </div>
                    </div>
                    <div class="col-auto">
                        <i class="fas fa-calendar-alt fa-2x text-gray-300"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="col-xl-3 col-md-6 mb-4">
        <div class="card border-left-primary shadow h-100 py-2">
            <div class="card-body">
                <div class="row no-gutters align-items-center">
                    <div class="col mr-2">
                        <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">
                            Daily Average (30 days)</div>
                        <div class="h5 mb-0 font-weight-bold text-gray-800">
                            <?= isset($attendance_stats['avg_daily']) ? $attendance_stats['avg_daily'] : 0; ?>
                        </div>
                    </div>
                    <div class="col-auto">
                        <i class="fas fa-chart-line fa-2x text-gray-300"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Today's Attendance -->
<div class="card shadow mb-4">
    <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
        <h6 class="m-0 font-weight-bold text-success">Today's Attendance - <?= date('F d, Y'); ?></h6>
        <div class="dropdown no-arrow">
            <a class="dropdown-toggle" href="#" role="button" id="dropdownMenuLink" data-toggle="dropdown">
                <i class="fas fa-ellipsis-v fa-sm fa-fw text-gray-400"></i>
            </a>
            <div class="dropdown-menu dropdown-menu-right shadow animated--fade-in">
                <div class="dropdown-header">Actions:</div>
                <a class="dropdown-item" href="#" onclick="exportTodayAttendance()">Export Today's Data</a>
                <a class="dropdown-item" href="#" onclick="sendAttendanceReport()">Send Report</a>
            </div>
        </div>
    </div>
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-bordered" id="todayTable" width="100%" cellspacing="0">
                <thead>
                    <tr>
                        <th>Member</th>
                        <th>Check In</th>
                        <th>Check Out</th>
                        <th>Duration</th>
                        <th>Status</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if (!empty($attendance)): ?>
                    <?php foreach ($attendance as $record): ?>
                    <tr>
                        <td>
                            <div class="d-flex align-items-center">
                                <div class="mr-2">
                                    <strong><?= $record['member_name'] ?? 'Unknown Member'; ?></strong><br>
                                    <small class="text-muted"><?= $record['member_code'] ?? 'N/A'; ?></small>
                                </div>
                            </div>
                        </td>
                        <td>
                            <span class="badge badge-success">
                                <?= date('H:i', strtotime($record['check_in_time'])); ?>
                            </span>
                        </td>
                        <td>
                            <?php if ($record['check_out_time']): ?>
                            <span class="badge badge-secondary">
                                <?= date('H:i', strtotime($record['check_out_time'])); ?>
                            </span>
                            <?php else: ?>
                            <span class="badge badge-warning">Still In</span>
                            <?php endif; ?>
                        </td>
                        <td>
                            <?php if ($record['check_out_time']): ?>
                            <?php
                                        $check_in = new DateTime($record['check_in_time']);
                                        $check_out = new DateTime($record['check_out_time']);
                                        $duration = $check_in->diff($check_out);
                                        echo $duration->format('%h:%I');
                                        ?>
                            <?php else: ?>
                            <?php
                                        $check_in = new DateTime($record['check_in_time']);
                                        $now = new DateTime();
                                        $duration = $check_in->diff($now);
                                        echo '<span class="text-info">' . $duration->format('%h:%I') . '</span>';
                                        ?>
                            <?php endif; ?>
                        </td>
                        <td>
                            <?php if ($record['check_out_time']): ?>
                            <span class="badge badge-secondary">Completed</span>
                            <?php else: ?>
                            <span class="badge badge-success">In Gym</span>
                            <?php endif; ?>
                        </td>
                        <td>
                            <div class="btn-group btn-group-sm" role="group">
                                <button type="button" class="btn btn-info"
                                    onclick="viewAttendanceDetails(<?= $record['id']; ?>)" title="View Details">
                                    <i class="fas fa-eye"></i>
                                </button>
                                <?php if (!$record['check_out_time']): ?>
                                <button type="button" class="btn btn-warning"
                                    onclick="manualCheckOut(<?= $record['id']; ?>)" title="Manual Check Out">
                                    <i class="fas fa-sign-out-alt"></i>
                                </button>
                                <?php endif; ?>
                                <button type="button" class="btn btn-danger"
                                    onclick="deleteAttendance(<?= $record['id']; ?>)" title="Delete Record">
                                    <i class="fas fa-trash"></i>
                                </button>
                            </div>
                        </td>
                    </tr>
                    <?php endforeach; ?>
                    <?php else: ?>
                    <tr>
                        <td colspan="6" class="text-center py-4">
                            <i class="fas fa-calendar-times fa-3x text-gray-300 mb-3"></i>
                            <p class="text-muted">No attendance records for today.</p>
                        </td>
                    </tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>

<!-- Quick Check-in -->
<div class="card shadow mb-4">
    <div class="card-header py-3">
        <h6 class="m-0 font-weight-bold text-info">
            <i class="fas fa-user-plus mr-2"></i>Quick Check-in
        </h6>
    </div>
    <div class="card-body">
        <div class="alert alert-info mb-3">
            <i class="fas fa-info-circle mr-2"></i>
            <strong>Instructions:</strong> Type member name or member code, select from suggestions, then click Check
            In.
        </div>

        <form id="quickCheckinForm">
            <div class="row">
                <div class="col-md-8">
                    <div class="form-group">
                        <label for="member_search" class="font-weight-bold">
                            <i class="fas fa-search mr-1"></i>Search Member (Name or Member Code)
                        </label>
                        <div class="input-group">
                            <div class="input-group-prepend">
                                <span class="input-group-text">
                                    <i class="fas fa-user"></i>
                                </span>
                            </div>
                            <input type="text" class="form-control" id="member_search"
                                placeholder="Type member name or code (e.g., John Doe or GYM001)..." autocomplete="off">
                            <div class="input-group-append">
                                <button type="button" class="btn btn-outline-secondary" onclick="clearSearch()">
                                    <i class="fas fa-times"></i>
                                </button>
                            </div>
                        </div>
                        <div id="member_suggestions" class="list-group mt-1"
                            style="position: absolute; z-index: 1000; width: calc(100% - 30px); display: none; max-height: 200px; overflow-y: auto;">
                        </div>
                        <small class="form-text text-muted">
                            <i class="fas fa-lightbulb mr-1"></i>Start typing to see member suggestions
                        </small>
                    </div>
                </div>
                <div class="col-md-4">
                    <label class="font-weight-bold">&nbsp;</label>
                    <button type="button" id="quickCheckinBtn" class="btn btn-success btn-block btn-lg"
                        onclick="quickCheckIn(this)" style="margin-top: 8px;">
                        <i class="fas fa-sign-in-alt mr-2"></i>Check In
                    </button>
                </div>
            </div>
        </form>
    </div>
</div>

<!-- Attendance Details Modal -->
<div class="modal fade" id="attendanceModal" tabindex="-1" role="dialog">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Attendance Details</h5>
                <button type="button" class="close" data-dismiss="modal">
                    <span>&times;</span>
                </button>
            </div>
            <div class="modal-body" id="attendanceModalBody">
                <!-- Content will be loaded here -->
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>

<script>
$(document).ready(function() {
    $('#todayTable').DataTable({
        "pageLength": 25,
        "order": [
            [1, "desc"]
        ], // Sort by check in time
        "columnDefs": [{
                "orderable": false,
                "targets": 5
            } // Disable sorting for Actions column
        ]
    });

    // Member search autocomplete
    $('#member_search').on('input', function() {
        const query = $(this).val();
        if (query.length >= 2) {
            $.ajax({
                url: '<?= base_url("gym/search_members"); ?>',
                type: 'GET',
                data: {
                    q: query
                },
                success: function(response) {
                    try {
                        const members = JSON.parse(response);
                        let suggestions = '';
                        if (members.length > 0) {
                            members.forEach(function(member) {
                                suggestions += `<a href="#" class="list-group-item list-group-item-action"
                                                  onclick="selectMember(${member.id}, '${member.name}', '${member.member_code}')">
                                                  <strong>${member.name}</strong><br>
                                                  <small class="text-muted">${member.member_code}</small>
                                                </a>`;
                            });
                        } else {
                            suggestions =
                                '<div class="list-group-item text-muted">No members found</div>';
                        }
                        $('#member_suggestions').html(suggestions).show();
                    } catch (e) {
                        console.error('Error parsing member search response:', e);
                        $('#member_suggestions').html(
                            '<div class="list-group-item text-danger">Error loading members</div>'
                        ).show();
                    }
                },
                error: function(xhr, status, error) {
                    console.error('Member search error:', status, error);
                    $('#member_suggestions').html(
                        '<div class="list-group-item text-danger">Error searching members</div>'
                    ).show();
                }
            });
        } else {
            $('#member_suggestions').hide();
        }
    });

    // Hide suggestions when clicking outside
    $(document).click(function(e) {
        if (!$(e.target).closest('#member_search, #member_suggestions').length) {
            $('#member_suggestions').hide();
        }
    });


});

let selectedMemberId = null;

function selectMember(id, name, code) {
    selectedMemberId = id;
    $('#member_search').val(`${name} (${code})`);
    $('#member_suggestions').hide();

    // Visual feedback
    $('#member_search').addClass('is-valid');
    setTimeout(function() {
        $('#member_search').removeClass('is-valid');
    }, 2000);
}

function clearSearch() {
    selectedMemberId = null;
    $('#member_search').val('').removeClass('is-valid is-invalid').focus();
    $('#member_suggestions').hide();
}

function quickCheckIn(buttonElement) {
    // Validation
    if (!selectedMemberId) {
        alert('Please select a member first from the search results');
        $('#member_search').focus();
        return;
    }

    // Get button reference - use passed element or find by ID
    const button = buttonElement || document.getElementById('quickCheckinBtn');
    if (!button) {
        console.error('Check-in button not found');
        return;
    }

    const originalText = button.innerHTML;

    // Show loading state
    button.innerHTML = '<i class="fas fa-spinner fa-spin mr-2"></i>Processing...';
    button.disabled = true;

    // AJAX request
    $.ajax({
        url: '<?= base_url("gym/quick_checkin"); ?>',
        type: 'POST',
        data: {
            member_id: selectedMemberId
        },
        success: function(response) {
            console.log('Check-in response:', response);

            try {
                const result = typeof response === 'string' ? JSON.parse(response) : response;

                if (result && result.success) {
                    // Success
                    alert('✅ Check-in successful!\n' + (result.message || ''));

                    // Reset form
                    selectedMemberId = null;
                    $('#member_search').val('');
                    $('#member_suggestions').hide();

                    // Reload page after short delay
                    setTimeout(function() {
                        location.reload();
                    }, 1000);
                } else {
                    // Error from server
                    const errorMsg = result && result.message ? result.message : 'Check-in failed';
                    alert('❌ Check-in Failed\n' + errorMsg);
                }
            } catch (e) {
                console.error('Response parsing error:', e);
                console.log('Raw response:', response);
                alert('❌ Error processing server response\nPlease try again or contact administrator');
            }
        },
        error: function(xhr, status, error) {
            console.error('AJAX Error:', status, error);
            console.log('Response Text:', xhr.responseText);

            let errorMessage = 'Connection error occurred';
            if (xhr.status === 404) {
                errorMessage = 'Check-in service not found';
            } else if (xhr.status === 500) {
                errorMessage = 'Server error occurred';
            } else if (xhr.responseText) {
                try {
                    const errorResponse = JSON.parse(xhr.responseText);
                    errorMessage = errorResponse.message || errorMessage;
                } catch (e) {
                    errorMessage = 'Server returned: ' + xhr.status;
                }
            }

            alert('❌ Connection Error\n' + errorMessage);
        },
        complete: function() {
            // Always restore button state
            if (button) {
                button.innerHTML = originalText;
                button.disabled = false;
            }
        }
    });
}

function viewAttendanceDetails(attendanceId) {
    $.ajax({
        url: '<?= base_url("gym/get_attendance_details/"); ?>' + attendanceId,
        type: 'GET',
        success: function(response) {
            $('#attendanceModalBody').html(response);
            $('#attendanceModal').modal('show');
        },
        error: function() {
            alert('Error loading attendance details');
        }
    });
}

function manualCheckOut(attendanceId) {
    if (confirm('Manually check out this member?')) {
        $.ajax({
            url: '<?= base_url("gym/manual_checkout/"); ?>' + attendanceId,
            type: 'POST',
            success: function(response) {
                const result = JSON.parse(response);
                if (result.success) {
                    alert('Check-out successful!');
                    location.reload();
                } else {
                    alert(result.message);
                }
            },
            error: function() {
                alert('Error processing check-out');
            }
        });
    }
}

function deleteAttendance(attendanceId) {
    if (confirm('Are you sure you want to delete this attendance record?')) {
        window.location.href = '<?= base_url("gym/delete_attendance/"); ?>' + attendanceId;
    }
}

function refreshAttendance() {
    location.reload();
}

function exportTodayAttendance() {
    window.open('<?= base_url("gym/export_attendance?date="); ?>' + '<?= date("Y-m-d"); ?>', '_blank');
}

function sendAttendanceReport() {
    if (confirm('Send today\'s attendance report via email?')) {
        $.ajax({
            url: '<?= base_url("gym/send_attendance_report"); ?>',
            type: 'POST',
            data: {
                date: '<?= date("Y-m-d"); ?>'
            },
            success: function(response) {
                alert('Report sent successfully!');
            },
            error: function() {
                alert('Error sending report');
            }
        });
    }
}
</script>

<!-- Page level plugins -->
<script src="<?= base_url('assets/'); ?>vendor/datatables/jquery.dataTables.min.js"></script>
<script src="<?= base_url('assets/'); ?>vendor/datatables/dataTables.bootstrap4.min.js"></script>

<!-- Page level custom scripts -->
<link href="<?= base_url('assets/'); ?>vendor/datatables/dataTables.bootstrap4.min.css" rel="stylesheet">