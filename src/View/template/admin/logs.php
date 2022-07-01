<section class="admin-section">
  <div class="container">
    <!--LOGS TABLE-->
      <?php if ($logs = $values['logs']) : ?>
      <div class="logs-table">
          <table>
              <thead>
                <tr>
                    <td>
                        ID
                    </td>
                    <td>
                        Type
                    </td>
                    <td>
                        Text
                    </td>
                    <td>
                        Time
                    </td>
                </tr>
              </thead>
              <tbody>
                <?php foreach ($logs as $value) : ?>
                    <tr>
                        <td>
                            <?= $value['id']; ?>
                        </td>
                        <td>
                          <?= $value['type']; ?>
                        </td>
                        <td>
                          <?= $value['text']; ?>
                        </td>
                        <td>
                          <?= $value['time']; ?>
                        </td>
                    </tr>
                <?php endforeach; ?>
              </tbody>
          </table>
      </div>
      <?php else : ?>
        <h2>
            No logs founded. <a href="/admin/log">Index log page</a>
        </h2>
      <?php endif; ?>
      <!--LOGS PAGINATION-->
      <?php if ($count = $values['count'] > 10 ? $values['count'] : false) : ?>
        <?= $this->getPagination($count); ?>
      <?php endif; ?>
  </div>
</section>