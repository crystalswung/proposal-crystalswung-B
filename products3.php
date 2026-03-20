<?php
session_start();

if(!isset($_SESSION["Username"])) {
    header("login.php");
}

?>
<!DOCTYPE html>
<head>
  <title>Mason's cinema</title>

<script>
    document.addEventListener('DOMContentLoaded', () => {
      const checkboxes = document.querySelectorAll('.product');
      const qtyInputs = document.querySelectorAll('.qty');
      const totalDisplay = document.getElementById('total');
      const clearBtn = document.getElementById('clearAll');
      const checkoutBtn = document.getElementById('checkout');

      checkboxes.forEach((checkbox, index) => {
        checkbox.addEventListener('change', () => {
          qtyInputs[index].disabled = !checkbox.checked;
          calculateTotal();
        });
      });

      qtyInputs.forEach(input => {
        input.addEventListener('input', calculateTotal);
      });

      clearBtn.addEventListener('click', () => {
        checkboxes.forEach((checkbox, index) => {
          checkbox.checked = false;
          qtyInputs[index].disabled = true;
          qtyInputs[index].value = 1;
        });
        calculateTotal();
      });

      checkoutBtn.addEventListener('click', () => {
        let summary = "You selected:\n";
        checkboxes.forEach((item, index) => {
          if (item.checked) {
            const name = item.parentElement.textContent.trim().split('-')[0].trim();
            const qty = qtyInputs[index].value;
            summary += `${name} x ${qty}\n`;
          }
        });
        summary += `Total: £${totalDisplay.textContent}`;
        alert(summary);
      });

      function calculateTotal() {
        let total = 0;
        checkboxes.forEach((item, index) => {
          if (item.checked) {
            const price = parseFloat(item.getAttribute('data-price'));
            const qty = parseInt(qtyInputs[index].value) || 1;
            total += price * qty;
          }
        });
        totalDisplay.textContent = total.toFixed(2);
      }
    });
  </script>
</head>
<body>
  <div class="wrapper">
    <h1>Welcome <?php echo $_SESSION["Username"]; ?></h1>
    <a href="logout.php">Logout Here</a><br>
  </div>
  <?php include 'connect.php';
  $query = $db->query("SELECT * FROM products");
  echo "<table>";
  while($row = $query->fetch(PDO::FETCH_ASSOC)) {
  echo "<div class=\"body\">
    <label>
      <input type=\"checkbox\" data-price=\"".$row['price']."\">".$row['name']." ".$row['description']."
    </label>
    Qty: <input type=\"number\" width=\"4\" value=\"1\" min=\"1\" disabled>
  </div>";

    } 
    echo "</table>"; ?>
    <h2>Total: £<span id="total">0.00</span></h2>

    <button id="clearAll">Clear All</button>
    <button id="checkout">Checkout</button>
</body>
</html>

