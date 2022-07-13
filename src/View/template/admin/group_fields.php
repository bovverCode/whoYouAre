<section class="fields">
  <div class="container">
    <form method="POST"
          action="/admin/fields/edit-group"
          class="group-app"
          id="group-app"
          enctype="multipart/form-data"
          data-id="<?=$values['group']['id'];?>"
          data-types="<?=$values['types'];?>"
    >
        <div class="group-app__title">
            <div class="caption">
                Group slug
            </div>
            <input type="text" placeholder="Name of group" value="<?= $values['group']['name']; ?>">
        </div>
        <div class="group-app__table">
            <table>
                <thead>
                    <tr>
                        <th>
                            Field slug
                        </th>
                        <th>
                            Field type
                        </th>
                        <th>
                            Field value
                        </th>
                        <th>
                            Actions
                        </th>
                    </tr>
                </thead>
                <tbody>
                <?php if (isset($values['fields']) && !empty($values['fields'])) : ?>
                    <?php foreach ($values['fields'] as $field) : ?>
                        <tr class="field-row field-row--exist">
                            <td class="field_slug">
                                <input type="text" name="field_slug" placeholder="Field slug" value="<?= $field['key']; ?>">
                            </td>
                            <td class="field_type">
                                <select name="field_type">
                                    <option value="text"<?= $field['type'] === 'text' ? ' selected' : '';?>>Text</option>
                                    <option value="image"<?= $field['type'] === 'image' ? ' selected' : '';?>>Image</option>
                                </select>
                            </td>
                            <td class="field_value">
                                <?php if ($field['type'] === 'text') : ?>
                                    <textarea name="field_value" cols="6" placeholder="Text content"><?= $field['value']; ?></textarea>
                                <?php elseif ($field['type'] === 'image') : ?>
                                    <input name="field_value" type="file"/>
                                <?php endif; ?>
                            </td>
                            <td>
                                <div class="admin-button">
                                    <button class="delete-field">
                                        Delete
                                    </button>
                                </div>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                <?php endif; ?>
                </tbody>
            </table>
            <div class="group-app__buttons">
                <div class="admin-button">
                    <button id="add-field">
                        Add field
                    </button>
                </div>
                <div class="admin-button">
                    <button type="submit">
                        Save
                    </button>
                </div>
            </div>
        </div>
    </form>
  </div>
</section>