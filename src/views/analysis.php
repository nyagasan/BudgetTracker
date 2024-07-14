<h1>支出分析</h1>
<canvas id="expenseChart" width="400" height="200"></canvas>

<h2 class="mb-3">週別支出詳細</h2>
<div class="table-responsive">
    <table class="table table-striped">
        <thead>
        <tr>
            <th>週</th>
            <th>総支出</th>
            <th>差額</th>
            <th>状態</th>
        </tr>
        </thead>
        <tbody>
        <?php foreach ($analysis as $week => $data): ?>
            <tr>
                <td><?= $week ?>週目</td>
                <td>¥<?= number_format($data['total']) ?></td>
                <td class="<?= $data['status'] === 'surplus' ? 'text-success' : 'text-danger' ?>">
                    ¥<?= number_format(abs($data['difference'])) ?>
                </td>
                <td><?= $data['status'] === 'surplus' ? '黒字' : '赤字' ?></td>
            </tr>
        <?php endforeach; ?>
        </tbody>
    </table>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        var ctx = document.getElementById('expenseChart').getContext('2d');
        var data = <?= json_encode($analysis) ?>;
        var weeks = Object.keys(data);
        var totals = weeks.map(week => data[week].total);
        var differences = weeks.map(week => data[week].difference);

        new Chart(ctx, {
            type: 'bar',
            data: {
                labels: weeks.map(week => week + '週目'),
                datasets: [{
                    label: '総支出',
                    data: totals,
                    backgroundColor: 'rgba(75, 192, 192, 0.6)'
                }, {
                    label: '差額',
                    data: differences,
                    backgroundColor: differences.map(diff => diff >= 0 ? 'rgba(54, 162, 235, 0.6)' : 'rgba(255, 99, 132, 0.6)')
                }]
            },
            options: {
                scales: {
                    y: {
                        beginAtZero: true
                    }
                }
            }
        });
    });
</script>
