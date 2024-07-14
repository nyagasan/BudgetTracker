<h1 class="mb-4">ホーム</h1>
<div class="row">
    <div class="col-md-6 mb-4">
        <div class="card">
            <div class="card-header">今日の予算</div>
            <div class="card-body">
                <p class="card-text">1食あたり: ¥<?= number_format($budget['meal'] ?? 0) ?></p>
                <p class="card-text">その他: ¥<?= number_format($budget['other'] ?? 0) ?></p>
                <p class="card-text">合計: ¥<?= number_format(($budget['meal'] ?? 0) * 3 + ($budget['other'] ?? 0)) ?></p>
            </div>
        </div>
    </div>
    <div class="col-md-6 mb-4">
        <div class="card">
            <div class="card-header">今日の支出</div>
            <div class="card-body">
                <p class="card-text">合計: ¥<?= number_format($dailyTotal) ?></p>
                <p class="card-text <?= $difference >= 0 ? 'text-success' : 'text-danger' ?>">
                    差額: ¥<?= number_format(abs($difference)) ?> (<?= $difference >= 0 ? '黒字' : '赤字' ?>)
                </p>
            </div>
        </div>
    </div>
</div>

<h2 class="mb-3">最近の支出</h2>
<?php if (!empty($expenses)): ?>
    <div class="table-responsive">
        <table class="table table-striped">
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
    </div>
<?php else: ?>
    <p class="alert alert-info">まだ支出の記録がありません。</p>
<?php endif; ?>