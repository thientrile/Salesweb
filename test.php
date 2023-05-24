<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css">


<table class="table">
  <tbody>
    <tr class="animate__animated">
      <td>Row 1, Column 1</td>
      <td>Row 1, Column 2</td>
      <td><button onclick="moveRowUp(this)">Move Up</button></td>
      <td><button onclick="moveRowDown(this)">Move Down</button></td>
    </tr>
    <tr class="animate__animated">
      <td>Row 2, Column 1</td>
      <td>Row 2, Column 2</td>
      <td><button onclick="moveRowUp(this)">Move Up</button></td>
      <td><button onclick="moveRowDown(this)">Move Down</button></td>
    </tr>
  </tbody>
</table>


<script>
  function moveRowUp(button) {
    let row = button.parentNode.parentNode;
    let previousRow = row.previousElementSibling;
    if (previousRow) {
      row.parentNode.insertBefore(row, previousRow);
      row.classList.add("animate__fadeInUp");
      previousRow.classList.add("animate__fadeOutDown");
      setTimeout(function() {
        row.classList.remove("animate__fadeInUp");
        previousRow.classList.remove("animate__fadeOutDown");
      }, 1000); // Adjust the delay (in milliseconds) to match the animation duration
    }
  }

  function moveRowDown(button) {
    let row = button.parentNode.parentNode;
    let nextRow = row.nextElementSibling;
    if (nextRow) {
      row.parentNode.insertBefore(nextRow, row);
      row.classList.add("animate__fadeInDown");
      nextRow.classList.add("animate__fadeOutUp");
      setTimeout(function() {
        row.classList.remove("animate__fadeInDown");
        nextRow.classList.remove("animate__fadeOutUp");
      }, 1000); // Adjust the delay (in milliseconds) to match the animation duration
    }
  }
</script>