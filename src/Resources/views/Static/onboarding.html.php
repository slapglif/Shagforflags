
<div id="onboarding" class="modal" tabindex="-1" role="dialog">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Share your hottest sex story with the world in three steps</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <ul class="list-group onbarding-listing">
                    <li class="list-group-item">
                        <i class="icomoon icon-globe"></i> Where did the sex happened
                    </li>
                    <li class="list-group-item">
                        <i class="icomoon icon-users"></i> Sex Partners Details
                    </li>
                    <li class="list-group-item">
                        <i class="icomoon icon-library_books"></i> Sex Story
                    </li>
                </ul>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-outline-primary onboard-close">Close (don't show again)</button>
                <button type="button" class="btn btn-primary" data-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>


<script>
    <?php
    if ($onboarding) {
        echo 'var load_onbard = false;';
    }else {
        echo 'var load_onbard = true;';
    }
    ?>
    $(window).on('load',function(){
        if (load_onbard) {
            $('#onboarding').modal('show');
        }
    });

    $('.onboard-close').on('click',function(){
        $.ajax({
            url: '/story/close-onboard',
            type: 'post',
            async: true,
            data: {},
            success: function (response) {
                $('#onboarding').modal('toggle');
            }
        });
    });
</script>
