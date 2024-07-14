<h1>支出記録</h1>
<?php if (isset($error)): ?>
    <div class="alert alert-danger"><?= htmlspecialchars($error) ?></div>
<?php endif; ?>
<form action="index.php?action=record_expense" method="post">
    <div class="mb-3">
        <label for="date" class="form-label">日付</label>
        <input type="date" class="form-control" id="date" name="date" required>
    </div>
    <div class="mb-3">
        <label for="type" class="form-label">種類</label>
        <select class="form-select" id="type" name="type" required>
            <option value="朝食">朝食</option>
            <option value="昼食">昼食</option>
            <option value="夕食">夕食</option>
            <option value="その他">その他</option>
        </select>
    </div>
    <div class="mb-3">
        <label for="amount" class="form-label">金額</label>
        <input type="number" class="form-control" id="amount" name="amount" required>
    </div>
    <div class="mb-3">
        <label for="note" class="form-label">メモ</label>
        <textarea class="form-control" id="note" name="note"></textarea>
    </div>
    <button type="submit" class="btn btn-primary">記録</button>
</form>