<?php
require_once("../../controllers/admin/sessionManage.php");
require_once("../../models/usersModel.php");
$currentUser=getUser($_SESSION["uid"]);
require_once("../../partials/formHelper.php");
require("../../controllers/admin/manageUsersControls.php");
?>
<!DOCTYPE html>
<html lang="en">
<head>
<?php require("../../partials/admin/head.php") ?>
<style>
            #middle {
                padding: 25px 30px;
                flex: 1;
                min-width: 0;
            }

            #top {
                display: flex;
                justify-content: space-between;
                align-items: center;
                margin-bottom: 25px;
            }

            #top h2 {
                margin: 0 0 8px;
            }

            #top p {
                margin: 0;
                color: gray;
                font-size: 13px;
            }

            #searchBox, #editBox {
                background-color: white;
                border: 1px solid #ddd;
                border-radius: 10px;
                padding: 10px 15px;
                margin-bottom: 25px;
            }

            #search {
                width: 350px;
                max-width: 100%;
            }

            #search label, #editBox label {
                display: block;
                font-size: 12px;
                font-weight: bold;
                margin-bottom: 5px;
            }

            #search input, #editBox input {
                width: 100%;
                height: 35px;
                border: 1px solid #ddd;
                border-radius: 7px;
                padding: 0 10px;
                box-sizing: border-box;
            }

            #editFields {
                display: grid;
                grid-template-columns: 1fr 1fr 1fr;
                gap: 15px;
                margin-bottom: 15px;
            }

            #userTable {
                width: 100%;
                border-collapse: collapse;
                background-color: white;
                border: 1px solid #ddd;
            }

            #userTable th {
                background-color: whitesmoke;
                color: gray;
                font-size: 12px;
                text-align: left;
                padding: 13px 10px;
            }

            #userTable td {
                padding: 15px 10px;
                border-bottom: 1px solid #ddd;
                font-size: 12px;
            }

            #actions {
                display: flex;
                gap: 10px;
                align-items: center;
            }

            #actions form {
                margin: 0;
            }

            #actions a, #actions button, #editBox button, #editBox a {
                background-color: transparent;
                color: blue;
                border: none;
                padding: 0;
                font-size: 12px;
                cursor: pointer;
                text-decoration: none;
            }

            #message {
                margin-bottom: 15px;
                font-size: 13px;
            }

            @media(max-width: 800px) {
                #editFields {
                    grid-template-columns: 1fr;
                }
            }
</style>
</head>
<body>
<?php require("../../partials/admin/header.php") ?>
<div id="middle">
            <div id="top">
                <div>
                    <h2>Manage Users</h2>
                    <p>View, search, modify and delete system users</p>
                </div>
            </div>

            <?php if($message!='') { ?>
                <div id="message"><?php echo h($message); ?></div>
            <?php } ?>

            <?php if($editUser && $editUser['type']!='ADMIN') { ?>
            <div id="editBox">
                <form method="post">
                    <?php formToken(); ?>
                    <input type="hidden" name="uid" value="<?php echo (int)$editUser['uid']; ?>">
                    <input type="hidden" name="action" value="update">

                    <div id="editFields">
                        <div>
                            <label>Name</label>
                            <input type="text" name="name" value="<?php echo h($editUser['name']); ?>" required>
                        </div>
                        <div>
                            <label>Email</label>
                            <input type="email" name="email" value="<?php echo h($editUser['email']); ?>" required>
                        </div>
                        <div>
                            <label>Phone</label>
                            <input type="text" name="phone" value="<?php echo h($editUser['phone']); ?>">
                        </div>
                    </div>

                    <button type="submit">Save Changes</button>
                    &nbsp;&nbsp;
                    <a href="manageUsers.php">Cancel</a>
                </form>
            </div>
            <?php } ?>

            <div id="searchBox">
                <div id="search">
                    <label for="searchRows">Search User</label>
                    <input type="text" id="searchRows" placeholder="Search by name, email, phone or role">
                </div>
            </div>

            <table id="userTable">
                <tr>
                    <th>User ID</th>
                    <th>Name</th>
                    <th>Email</th>
                    <th>Phone</th>
                    <th>Role</th>
                    <th>Actions</th>
                </tr>

                <?php foreach ($users as $user) { ?>
                <tr>
                    <td><?php echo (int)$user['uid']; ?></td>
                    <td><?php echo h($user['name']); ?></td>
                    <td><?php echo h($user['email']); ?></td>
                    <td><?php echo h($user['phone']); ?></td>
                    <td><?php echo h($user['type']); ?></td>
                    <td>
                        <?php if($user['type']!='ADMIN') { ?>
                        <div id="actions">
                            <a href="manageUsers.php?edit=<?php echo (int)$user['uid']; ?>">Modify</a>

                            <form method="post" onsubmit="return confirm('Delete this user?');">
                                <?php formToken(); ?>
                                <input type="hidden" name="uid" value="<?php echo (int)$user['uid']; ?>">
                                <button type="submit" name="action" value="delete">Delete</button>
                            </form>
                        </div>
                        <?php } ?>
                    </td>
                </tr>
                <?php } ?>
            </table>

            <script src="../../js/search.js"></script>
        </div>
<?php require("../../partials/admin/header-end.php") ?>
</body>
</html>
