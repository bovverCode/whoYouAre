<section class="fields">
  <div class="container">
    <h2>
        Field groups
    </h2>
      <div class="fields__table">
        <table>
            <thead>
                <tr>
                    <th>
                        Group name
                    </th>
                    <th>
                        Actions
                    </th>
                </tr>
            </thead>
            <tbody>
            <?php if (isset($values['groups']) && !empty($values['groups'])) : ?>
                <?php foreach ($values['groups'] as $group) : ?>
                    <tr>
                        <td>
                            <h4>
                              <?= $group['name']; ?>
                            </h4>
                        </td>
                        <td>
                            <div class="admin-button">
                                <a href="/admin/fields/group/<?= $group['id']; ?>">
                                    Edit
                                </a>
                            </div>
                        </td>
                    </tr>
                <?php endforeach; ?>
            <?php endif; ?>
            </tbody>
        </table>
    </div>
     <?php if (!isset($values['groups']) || empty($values['groups'])) : ?>
     <h2>
         Groups not found.
     </h2>
     <?php endif; ?>
    </div>
    <form method="POST" action="/admin/fields/add-group" class="fields__form" id="add-group">
        <h3>
            Add field group
        </h3>
      <div class="admin-input">
        <input type="text" name="group_name" placeholder="Group name">
      </div>
      <div class="admin-button">
        <button type="submit">
          Submit
        </button>
      </div>
      <ul class="error-list">
      </ul>
    </form>
  </div>
</section>