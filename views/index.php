<?php
    use \CsvTool\DTO\Session;
    use \CsvTool\System\CSV;
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>CSV Tool</title>
  <style>
    body { font-family: sans-serif; padding: 1rem; }
    
    table { border-collapse: collapse; margin-top: 1rem; }
    
    th, td { padding: .5rem; border: 1px solid #ccc; }
    
    td:last-child { text-align: right; }
    
    .error, .success { padding: 1rem 0; }
    .error { color: red; }
    .success { color: green; }

    input[type=file]::file-selector-button,
    button {
        background: #eee;
        border: 1px solid #aaa;
        border-radius: .25rem;
        color: #000;
        cursor: pointer;
        transition: background .5s ease-in-out;
    }

    input[type=file]::file-selector-button {
        margin-right: 1rem;
        padding: .25rem 1rem;
    }

    button {
        display: block;
        margin: 1rem 0 3rem;
        padding: .5rem 2rem;
    }

    button:focus,
    button:hover,
    input[type=file]::file-selector-button:hover {
        background: #ccc;
    }
  </style>
</head>
<body>

  <h1>Upload Expense Report CSV</h1>

  <form action="/upload" method="POST" enctype="multipart/form-data">
    <input type="file" name="csv_file" accept=".csv" required>
    <button type="submit">Upload</button>
  </form>

  <?php if (Session::has('error')): ?>
    <p class="error"><?php Session::flash('error'); ?></p>
  <?php endif; ?>

  <?php if (Session::has('success')): ?>
    <p class="success"><?php Session::flash('success'); ?></p>
  <?php endif; ?>

  <?php if (Session::has('summary')): ?>
    <h2>Summary</h2>
    <table>
      <tr><th>Category</th><th>Total Cost</th></tr>
      <?php foreach (Session::get('summary') as $category => $total): ?>
        <tr>
          <td><?php echo htmlspecialchars($category); ?></td>
          <td><?php echo CSV::formatValue($total); ?></td>
        </tr>
      <?php endforeach; ?>
    </table>
    <p><a href="/download">Download this report as CSV</a></p>
  <?php endif; ?>

</body>
</html>
