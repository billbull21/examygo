<?php
//always call core/init.php to initialize the system
require_once "../Core/init.php";

if (!Session::exists('examygoUser')) {
    Redirect::to('/examygo/user/login.php');
}

$courseId = $course->getCourse('course_id', $_GET['id']);
$activitys = $course->getActivity('', '', 'activity_date', 'ASC');

require_once "../Views/Templates/header.php";
?>

<div id="alert"></div>

<div class="row m-2">
    <div class="col col-md shadow-sm rounded bg-white m-2 py-2">
        <h3><?= $courseId['course_full_name']; ?></h3>
        <hr />

        <?php if (!empty($activitys)) : foreach ($activitys as $activity) : ?>
                <?php if ($activity['course_id'] == $courseId['course_id']) : ?>
                    <div id="activityWrapper">
                        <?= $activity['activity_date']; ?>
                        <ul>
                            <li><a href="/examygo/courses/activity.php?course_id=<?=$courseId['course_id']?>&id=<?= $activity['activity_id'] ?>"><?= $activity['activity_name'] ?></a></li>
                        </ul>
                    </div>
                <?php endif ?>
            <?php endforeach;
    endif; ?>
        <?php if ($user->getUser('username', Session::get('examygoUser'))['role'] == 2) { ?>
            <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#activityModal">Add Activity</button>

            <div class="modal fade" id="activityModal" role="dialog">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="activityModalLabel">Add Activity</h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <form id="insertActivity" method="post">
                            <div class="modal-body">
                                <div class="form-group">
                                    <label for="activity-name" class="col-form-label">Activity Name<span class="text-danger">*</span></label>
                                    <input type="text" class="form-control" id="activity-name" required />
                                </div>
                                <div class="form-group">
                                    <label for="message-text" class="col-form-label">Activity Date<span class="text-danger">*</span></label>
                                    <span class="row p-3">
                                        <input type="text" class="form-control col col-sm" id="datepicker" readonly required />&nbsp;
                                        <span class="input-group col col-sm clockpicker">
                                            <input type="text" class="form-control" id="timepicker" readonly required />
                                            <span class="input-group-append">
                                                <span class="input-group-text"><span class="fas fa-clock" style="font-size: 24px;"></span></span>
                                            </span>
                                        </span>
                                    </span>
                                </div>
                                <div class="form-group">
                                    <label for="message-text" class="col-form-label">Activity Expired</label>
                                    <span class="row p-3">
                                        <input type="text" class="form-control col col-sm" id="expiredatepicker" readonly required />&nbsp;
                                        <span class="input-group col col-sm clockpicker">
                                            <input type="text" class="form-control" id="expiretimepicker" readonly required />
                                            <span class="input-group-append">
                                                <span class="input-group-text"><span class="fas fa-clock" style="font-size: 24px;"></span></span>
                                            </span>
                                        </span>
                                    </span>
                                </div>
                                <input type="hidden" id="csrf" value="<?= Helper::generateToken() ?>" id="csrf" />
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
                                <button class="btn btn-primary" type="submit" name="submit" id="activity-submit">Submit</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        <?php } ?>
    </div>
</div>
<script>
    var token = "<?php echo $_SESSION['token']; ?>";
    var id = "<?php echo $courseId['course_id']; ?>";

    $("#insertActivity").on('submit', function(e) {
        e.preventDefault();
        var name = $('#activity-name').val();
        var date = $('#datepicker').val(); //MM/dd/YYYY
        var clock = $('#timepicker').val(); //10:32 //H:I
        var expire = $('#expiredatepicker').val();
        var expireclock = $('#expiretimepicker').val();
        var csrf = $('#csrf').val();
        if (name == '' || name.length <= 3) {
            Swal.fire("Sorry!", "minimum character you must fill is 3!", "error");
        } else if (date == '' || date.length != 10 || clock == '') {
            Swal.fire("Sorry!", "please, fill the form correctly!!!", "error");
        } else if (expire == '' || date.length != 10 || expireclock == '') {
            Swal.fire("Sorry!", "please, fill the form correctly!!!", "error");
        } else if (Date.parse(expire) < Date.parse(date)) {
            Swal.fire("Sorry!", "please, the expire date must be greater than date!!!", "error");
        } else if (Date.parse(expire) == Date.parse(date) && parseInt(expireclock.substr(0, 2)) < parseInt(clock.substr(0, 2))) {
            Swal.fire("Sorry!", "please, the expire time must be greater than time!!!", "error");
        } else if (parseInt(expireclock.substr(0, 2)) == parseInt(clock.substr(0, 2)) && parseInt(expireclock.substr(3)) <= parseInt(clock.substr(3))) {
            Swal.fire("Sorry!", "please, the expire time must be greater than time!", "error");
        } else if (csrf != token) {
            alert('token is not valid!');
        } else {
            $.ajax({
                method: "POST",
                url: "ajax.php",
                data: {
                    activity_name: name,
                    activity_date: date,
                    clock: clock,
                    activity_expire: expire,
                    expireclock: expireclock,
                    course_id: id
                },
                success: function(data) {
                    if (data == 'gagal') {
                        Swal.fire("Sorry!", "fail to upload data!", "error");
                    } else {
                        $('#activityModal').modal('hide');
                        Swal.fire({
                            title: 'Good job!',
                            text: "Data success added!",
                            type: 'success',
                            showCancelButton: false,
                            confirmButtonColor: '#3085d6',
                            confirmButtonText: 'OK'
                        }).then((result) => {
                            if (result.value) {
                                location.reload();
                            }
                        });
                    }
                }
            });
        }
    });
</script>
<?php require_once "../Views/Templates/footer.php"; ?>