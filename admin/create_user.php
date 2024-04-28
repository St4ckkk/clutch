<?php
require 'admin.php';
?>

<div class="container mt-5">
    <div class="card mx-auto" style="width: 18rem;">
        <div class="card-body">
            <form action="create_user.php" method="post" class="form-inline">
                <div class="form-group">
                    <label for="username">NUsername:</label>
                    <input type="text" id="username" name="username" class="form-control" required>
                </div>
                <div class="form-group">
                    <label for="password">Password:</label>
                    <input type="password" id="password" name="password" class="form-control" required>
                </div>
                <button type="submit" class="btn btn-primary">Submit</button>
            </form>
        </div>
    </div>
</div>