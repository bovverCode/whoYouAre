<?php
/**
 * Admin auth template
 */
?>
<section class="auth">
    <div class="container">
        <div class="auth__wrap">
            <form method="POST" action="/admin/auth" class="auth__panel">
                <div class="auth__field">
                    <input type="text" name="name" placeholder="Name">
                </div>
                <div class="auth__field">
                    <input type="password" name="password" placeholder="Password">
                </div>
                <div class="auth__field">
                    <button type="submit" class="btn btn-auth">
                        Submit
                    </button>
                </div>
                <?php if (isset($values['errors']) && $errors = $values['errors']) : ?>
                    <ul class="auth__errors">
                        <?php foreach ($errors as $error) : ?>
                            <li>
                                <?= $error; ?>
                            </li>
                        <?php endforeach; ?>
                    </ul>
                <?php endif; ?>
            </form>
        </div>
    </div>
</section>
