loadExpense();
$btnAction = "Insert";
$("#addNew").on("click", () => {
  $("#expenseModal").modal("show");
});

$("#expenseForm").on("submit", (e) => {
  e.preventDefault();
  // let formData = new FormData($("#expenseForm")[0]);
  // formData.append("action", "reg_expense");
  let sendingData = {};
  let amount = $("#amount").val();
  let type = $("#type").val();
  let desc = $("#desc").val();
  let id = $("#id").val();
  if ($btnAction == "Insert") {
    sendingData = {
      action: "reg_expense",
      amount,
      type,
      desc,
    };
  } else {
    sendingData = {
      id,
      action: "update_expense",
      amount,
      type,
      desc,
    };
  }
  $.ajax({
    url: "../api/expense.php",
    type: "POST",
    data: sendingData,
    dataType: "json",
    success: (data) => {
      let response = data.message;
      let status = data.status;

      if (status) {
        displayMessage("success", response);
        $btnAction = "Insert";
        loadExpense();
      } else {
        displayMessage("error", response);
        console.log(response);
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
      let tr = "";
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

function deleteExpense(id) {
  let sendingData = {
    action: "delete_expense",
    id,
  };
  $.ajax({
    url: "../api/expense.php",
    type: "POST",
    data: sendingData,
    dataType: "json",
    success: function (response) {
      let data = response.message;
      console.log(data);
      let status = response.status;
      console.log(status);
      if (status) {
        Swal.fire({
          title: "Good job!",
          text: data,
          icon: "success",
        });

        loadExpense();
      } else {
        Swal.fire({
          title: "Deleted!",
          text: data,
          icon: "error",
        });
      }
    },
    error: function (error) {
      alert("Error deleting expense", error.responseText);
    },
  });
}

function fetchInfo(id) {
  let sendingData = {
    action: "getSingleExpense",
    id: id,
  };

  $.ajax({
    url: "../api/expense.php",
    type: "POST",
    data: sendingData,
    dataType: "json",
    success: function (response) {
      let data = response.message;
      let status = response.status;
      if (status) {
        console.log(data);
        $("#id").val(data["id"]);
        $("#amount").val(data["amount"]);
        $("#type").val(data["type"]);
        $("#desc").val(data["description"]);
        $("#expenseModal").modal("show");
        $btnAction = "Update";
      }
    },
    error: function (error) {
      alert("Error loading expenses", error.responseText);
    },
  });
}

$("#expenseTable").on("click", ".delete-expense", function () {
  let id = $(this).attr("data-id");
  if (confirm("Do you want to delete this expense or income?")) {
    deleteExpense(id);
  }
});
$("#expenseTable").on("click", ".edit-expense", function () {
  let id = $(this).attr("data-id");
  fetchInfo(id);
});
