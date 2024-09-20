loadUsers();
$btnAction = "Insert";

let fileImage = document.querySelector("#image");
let showInput = document.querySelector("#show");

const reader = new FileReader();
fileImage.addEventListener("change", (e) => {
  const selectedFile = e.target.files[0];
  reader.readAsDataURL(selectedFile);
});

reader.onload = (e) => {
  showInput.src = e.target.result;
};

$("#addNew").on("click", () => {
  $("#userModal").modal("show");
});

$("#userForm").on("submit", (e) => {
  e.preventDefault();
  let formData = new FormData($("#userForm")[0]);
  formData.append("image", $("input[type=file]")[0].files[0]);

  if ($btnAction == "Insert") {
    formData.append("action", "reg_user");
  } else {
    formData.append("action", "update_user");
  }
  $.ajax({
    url: "../api/users.php",
    type: "POST",
    data: formData,
    dataType: "json",
    processData: false,
    contentType: false,

    success: (data) => {
      let response = data.message;
      let status = data.status;

      if (status) {
        displayMessage("success", response);
        $btnAction = "Insert";
        loadUsers();
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

function loadUsers() {
  $("#userTable tr").empty();
  let sendingData = {
    action: "load_users",
  };

  $.ajax({
    url: "../api/users.php",
    type: "POST",
    data: sendingData,
    dataType: "json",
    success: function (response) {
      let data = response.message;
      let tr = "";
      let th = "";
      data.forEach((users) => {
        th = "<tr>";
        for (let i in users) {
          th += `<th>${i}</th>`;
        }
        th += "<th>Actions</th></tr>";

        tr += "<tr>";
        for (i in users) {
          if (i == "image") {
            tr += `<td><img style="width:50px;hieght:50px;border-radius:50%;border:1px solid #e3ebe7 object-fit:cover;s" class="w" src ="../uploads/${users[i]}"></td>`;
          } else {
            tr += `<td>${users[i]}</td>`;
          }
        }
        tr += `<td>
        <button class='btn btn-sm btn-info edit-expense' data-id='${users.id}'><i class="fas fa-edit" style="color:#000;"></i></button>
        <button class='btn btn-sm btn-danger delete-expense' data-id='${users.id}'><i class="fas fa-trash"></i></button>
        </td>`;

        tr += "</tr>";
      });
      $("#userTable thead").append(th);
      $("#userTable tbody").append(tr);
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
      $("#userForm")[0].reset();
      $("#userModal").modal("hide");
      success.addClass("d-none");
      loadUsers();
    }, 1000);
  } else {
    error.removeClass("d-none");
    error.text(message);
    success.addClass("d-none");
    setTimeout(function () {
      $("#expenseForm")[0].reset();
      $("#expenseModal").modal("hide");
      error.addClass("d-none");
      loadUsers();
    }, 1000);
  }
}

function deleteUser(id) {
  let sendingData = {
    action: "delete_User ",
    id,
  };
  $.ajax({
    url: "../api/users.php",
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

        loadUsers();
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
    action: "getSingleUser",
    id: id,
  };

  $.ajax({
    url: "../api/users.php",
    type: "POST",
    data: sendingData,
    dataType: "json",
    success: function (response) {
      let data = response.message;
      let status = response.status;
      if (status) {
        $("#id").val(data["id"]);
        $("#username").val(data["username"]);
        $("#password").val(data["password"]);
        $("#show").attr("src", `../uploads/${data["image"]}`);
        $("#userModal").modal("show");
        $btnAction = "Update";
      }
    },
    error: function (error) {
      alert("Error loading user", error.responseText);
    },
  });
}

$("#userTable").on("click", ".delete-expense", function () {
  let id = $(this).attr("data-id");
  if (confirm("Do you want to delete this expense or income? :" + id)) {
    deleteUser(id);
  }
});
$("#userTable").on("click", ".edit-expense", function () {
  let id = $(this).attr("data-id");
  fetchInfo(id);
});
