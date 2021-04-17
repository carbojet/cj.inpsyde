<?php
/*
** Template Name : custom 404 page for user table
**
*/
get_header();

    global $CJUserTable;
    $users = $CJUserTable->get_users();
    //echo '<pre>';
    //var_dump($users);
    //echo '<pre/>';
    ?>
        <div class="container">
            <table class="table">
                <thead>
                    <tr>
                    <th scope="col">#</th>
                    <th scope="col">Name</th>
                    <th scope="col">User Name</th>
                    <th scope="col">Email</th>
                    <th scope="col">Phone</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach($users as $user){?>
                        <tr>
                            <th scope="row"><?php echo $user->id;?></th>
                            <td><?php echo $user->name;?></td>
                            <td><?php echo $user->username;?></td>
                            <td><?php echo $user->email;?></td>
                            <td><?php echo $user->phone;?></td>
                        </tr>
                    <?php }?>
                </tbody>
            </table>
            <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#userDetailModal">
                Show User Detail
            </button>
        </div>

        <div class="modal fade" id="userDetailModal" tabindex="-1" role="dialog" aria-labelledby="userDetailModalLabel" aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="userDetailModalLabel">User Details</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        
                    </div>
                </div>
            </div>
        </div>
    <?php
get_footer();

?>