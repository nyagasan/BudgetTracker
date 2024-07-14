<h1>ホーム</h1>
<div class="row">
    <div class="col-md-6">
        <h2>今日の予算</h2>
        <p>1食あたり: ¥<?= number_format($budget['meal'] ?? 0) ?></p>
        <p>その他: ¥<?= number_format($budget['other'] ?? 0) ?></p>
        <p>合計: ¥<?= number_format(($budget['meal'] ?? 0) * 3 + ($budget['other'] ?? 0)) ?></p>
    </div>
    <div class="col-md-6">
        <h2>今日の支出</h2>
        <p>合計: ¥<?= number_format($dailyTotal) ?></p>
        <p class="<?= $difference >= 0 ? 'text-success' : 'text-danger' ?>">
            差額: ¥<?= number_format(abs($difference)) ?> (<?= $difference >= 0 ? '黒字' : '赤字' ?>)
        </p>
    </div>
</div>

<h2 class="mt-4">最近の支出</h2>
<?php if (!empty($expenses)): ?>
    <table class="table">
        <thead>
        <tr>
            <th>日付</th>
            <th>種類</th>
            <th>金額</th>
            <th>メモ</th>
        </tr>
        </thead>
        <tbody>
        <?php foreach (array_slice(array_reverse($expenses), 0, 5) as $expense): ?>
            <tr>
                <td><?= htmlspecialchars($expense['date']) ?></td>
                <td><?= htmlspecialchars($expense['type']) ?></td>
                <td>¥<?= number_format($expense['amount']) ?></td>
                <td><?= htmlspecialchars($expense['note']) ?></td>
            </tr>
        <?php endforeach; ?>
        </tbody>
    </table>
<?php else: ?>
    <p>まだ支出の記録がありません。</p>
<?php endif; ?>