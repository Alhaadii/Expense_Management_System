$("#from").attr("disabled", true);
$("#to").attr("disabled", true);

$("#type").on("change", function () {
  if ($("#type").val() == "0") {
    $("#from").attr("disabled", true);
    $("#to").attr("disabled", true);
  } else {
    $("#from").attr("disabled", false);
    $("#to").attr("disabled", false);
  }
});

$("#userForm").on("submit", (e) => {
  e.preventDefault();

  $("#userTable tr").empty();

  let from = $("#from").val();
  let to = $("#to").val();

  let sendingData = {
    from,
    to,
    action: "getUserStatement",
  };
  $.ajax({
    url: "../api/expense.php",
    type: "POST",
    data: sendingData,
    dataType: "json",
    success: (data) => {
      let response = data.message;
      let status = data.status;
      let tr = "";
      let th = "";
      if (status) {
        response.forEach((report) => {
          th = "<tr>";
          for (let i in report) {
            th += `<th>${i}</th>`;
          }
          th += "</tr>";

          tr += "<tr>";
          for (let i in report) {
            tr += `<td>${report[i]}</td>`;
          }
          tr += `</tr>`;
        });
        $("#userTable thead").append(th);
        $("#userTable tbody").append(tr);
        $("#userForm")[0].reset();
      } else {
        displayMessage("error", response);
      }
    },
    error: function (error) {
      displayMessage("error", error.responseText);
      console.log(error.responseText);
    },
  });
});

function loadExpense() {
  $("#expenseTable tbody").empty();
  let sendingData = {
    action: "load_expense",
  };

  $.ajax({
    url: "../api/expense.php",
    type: "POST",
    data: sendingData,
    dataType: "json",
    success: function (response) {
      let data = response.message;
      let status = response.status;
      let tr = "";
      if (status) {
        data.forEach((expense) => {
          tr += "<tr>";
          for (i in expense) {
            if (i == "type") {
              if (expense[i] == "Income") {
                tr += `<td ><span class="badge badge-success">${expense[i]}</span></td>`;
              } else {
                tr += `<td><span class="badge badge-danger">${expense[i]}</span></td>`;
              }
            } else {
              tr += `<td>${expense[i]}</td>`;
            }
          }
          tr += `<td>
            <button class='btn btn-sm btn-info edit-expense' data-id='${expense.id}'><i class="fas fa-edit" style="color:#000;"></i></button>
            <button class='btn btn-sm btn-danger delete-expense' data-id='${expense.id}'><i class="fas fa-trash"></i></button>
            </td>`;

          tr += "</tr>";
        });
        $("#expenseTable tbody").append(tr);
      }
    },
    error: function (error) {
      alert("Error loading expenses", error.responseText);
    },
  });
}

function displayMessage(type, message) {
  let success = $(".alert-success");
  let error = $(".alert-danger");

  if (type == "success") {
    success.removeClass("d-none");
    success.text(message);
    error.addClass("d-none");

    setTimeout(function () {
      $("#expenseForm")[0].reset();
      $("#expenseModal").modal("hide");
      success.addClass("d-none");
      loadExpense();
    }, 1000);
  } else {
    error.removeClass("d-none");
    error.text(message);
    success.addClass("d-none");
    setTimeout(function () {
      $("#expenseForm")[0].reset();
      $("#expenseModal").modal("hide");
      error.addClass("d-none");
      loadExpense();
    }, 1000);
  }
}

$("#print").on("click", function () {
  printStatement();
});

function printStatement() {
  let printArea = document.querySelector("#printArea");
  let newWindow = window.open();

  newWindow.document.write(`<html><head><title>User Statement</title>`);
  newWindow.document.write(`<meta name="viewport" content="width=device-width`);
  newWindow.document.write(`<style>

    @import url('https://fonts.googleapis.com/css2?family=Poppins:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&display=swap');

    body {
        font-family: "Poppins", sans-serif;
        font-weight: 500;
        font-style: normal;
    }

    table {
      width: 100% !important;
    }
    th {
      background-color:green !important;
      color:white !important;
    }
    th, td {
    text-align:left !important;
    padding: 15px !important;
    border-bottom: 1px solid #ddd !important;
    }


</style>`);

  newWindow.document.write(`</head><body>`);
  newWindow.document.write(printArea.innerHTML);
  newWindow.document.write(`</body></html>`);
  newWindow.print();
  newWindow.close();
}

$("#export").on("click", function () {
  let file = new Blob([$("#printArea").html()], {
    type: "application/vnd.ms-excel",
  });
  let url = URL.createObjectURL(file);
  let a = $("<a />", {
    href: url,
    download: "user_statement.xls"
  })
    .appendTo("body")
    .get(0)
    .click();
  e.preventDefault();
});
