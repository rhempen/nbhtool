<table 
    class="table"
    data-toggle="table"
    data-search="true"
    data-show-columns="true"
    data-show-toggle="false"
    data-dropdown-toggle="true"
    data-mobile-responsive="true"
    data-sortable="true"
    data-show-export="true"
>
    <thead>
        <tr>
            <th data-sortable="true">Name</th>
            <th data-sortable="true">Adresse</th>
            <th data-visible="false" data-sortable="true">Geburtsdatum</th>
            <th data-sortable="true">Email</th>
            <th data-sortable="true">Telefon</th>
        </tr>
    </thead>
    <tbody>
    <?php foreach($data as $person): ?>
        <tr>
            <td data-sortable="true">
                <?= $person['firstname'] ?>
            
            </td>
            <td><?= $person['lastname'] ?></td>
            <td><?= $person['firstname'] ?></td>
            <td><?= $person['firstname'] ?></td>
            <td><?= $person['phone_mobile'] ?></td>
        </tr>
    <?php endforeach; ?>
    </tbody>
</table>
