<?php

require_once "lib/helpers.php";

$column = 'last_name';
$direction = 'asc';

$sort = req('sort');
$sort = explode(':', $sort);
if (count($sort) > 1) {
    $column = $sort[0];
    $direction = $sort[1];
}

$data = [
    'qstring' => [
        'last_name' => "?sort=last_name:asc",
        'active' => "?sort=active:asc",
        'line1' => "?sort=line1:asc",
    ],
];
$toggled = $direction === 'asc' ? 'desc' : 'asc';
$data['qstring'][$column] = "?sort={$column}:{$toggled}";

try {
    $users = getUsersWithLocations([
        'column' => $column,
        'direction' => $direction,
    ]);
    
} catch (Exception $e) {
    $data['exception'] = $e;
}

$data['users'] = $users;
$data['page_title'] = 'Employee Directory';

render($data, function($data) {
?>
    <div class="table responsive">
        <table class="stripped">
            <thead>
                <tr>
                    <th><a href="<?= $data['qstring']['active'] ?>">Active</a></th>
                    <th><a href="<?= $data['qstring']['last_name'] ?>">Employee Name</a></th>
                    <th><a href="<?= $data['qstring']['line1'] ?>">Location</a></th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
            <?php foreach($data['users'] as $user): ?>
                <tr 
                    <?= $user->active ? '' : ' class="user-inactive" ' ?>
                >
                    <td><?= $user->active ? 'Yes' : 'No' ?></td>
                    <td><?= _esc("{$user->last_name}, {$user->first_name}") ?></td>
                    <td><?= _esc("$user->line1; $user->city, $user->state $user->zip") ?></td>
                    <td>
                        <a href="/employees/edit.php?user_id=<?= $user->id ?>">edit</a>
                        | <a href="/employees/delete.php?user_id=<?= $user->id ?>">delete</a>
                    </td>
                </tr>
            <?php endforeach ?>
            </tbody>
        </table>
    </div>
<?php
});
