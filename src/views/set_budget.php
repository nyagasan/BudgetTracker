<h1 class="mb-4">予算設定</h1>
<?php if (isset($error)): ?>
    <div class="alert alert-danger"><?= htmlspecialchars($error) ?></div>
<?php endif; ?>
<form action="index.php?action=set_budget" method="post">
    <div class="mb-3">
        <label for="meal" class="form-label">1食あたりの予算</label>
        <input type="number" class="form-control" id="meal" name="meal" required>
    </div>
    <div class="mb-3">
        <label for="other" class="form-label">1日のその他支出予算</label>
        <input type="number" class="form-control" id="other" name="other" required>
    </div>
    <button type="submit" class="btn btn-primary">設定</button>
</form>