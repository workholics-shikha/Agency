$(document).ready(function () {
  // Trigger the filter when the button is clicked
  $("#filterButton").click(function () {
    var start_date = $("#start_date").val();
    var end_date = $("#end_date").val();
    var theater = document.getElementById("theater").value;
    var a_id = document.getElementById("a_id").value;

    // Make an AJAX request to fetch filtered data
    $.ajax({
      url: "filter_data.php",
      type: "GET",
      data: {
        start_date: start_date,
        end_date: end_date,
        theater: theater,
        a_id: a_id,
      },

      dataType: "json",
      success: function (response) {
        $("#filterTable").css("display", "block");

        reloadDataTable(response);

        let dataSet = [];
        let serialNumber = 1;

        if (Array.isArray(response) && response.length > 0) {
          response.forEach((item) => {
            dataSet.push([
              `${serialNumber++}. <input type="checkbox" class="rowCheckbox" value="${
                item[0]
              }">`, // Checkbox<a target=\"_blank\" href=\"entryform.php?id="${item[0]}" class=\"btn btn-primary\"> <i class=\"fa fa-pencil-square-o\" aria-hidden=\"true\"></i> </a> class="btn btn-primary" data-toggle="modal" data-target="#editReportModal"
              `<button type="button" class="btn btn-primary editModalBody" data-id="${item[0]}"> 
  <i class="fa fa-pencil-square-o" aria-hidden="true"></i> 
</button>
<a type=\"button\" class='btn btn-danger' onclick='deleteData("${item[0]}")'> <i class=\"fa fa-remove\" aria-hidden=\"true\"></i> </a>`,
              `<input type="text" name='theater_name["${item[0]}"]' value="${item[1]}" /> <p class="toBeHidden">${item[1]}</p>`, // Theater Name (Editable)
              `<input type="text" name='thcode["${item[0]}"]' value="${item[5]}" /> <p class="toBeHidden">${item[5]}</p>`,
              `<input type="text" name='caption["${item[0]}"]' value="${item[13]}" /> <p class="toBeHidden">${item[13]}</p>`,
              `<input type="text" name='airdate["${item[0]}"]' value="${item[6]}" /> <p class="toBeHidden">${item[6]}</p>`, //date
              `<input type="text" name='starttime["${item[0]}"]' value="${item[7]}" /> <p class="toBeHidden">${item[7]}</p>`,
              `<input type="text" name='endtime["${item[0]}"]' value="${item[8]}" /> <p class="toBeHidden">${item[8]}</p>`,
              `<input type="text" name='region["${item[0]}"]' value="${item[2]}" /> <p class="toBeHidden">${item[2]}</p>`,
              `<input type="text" name='district["${item[0]}"]' value="${item[3]}" /> <p class="toBeHidden">${item[3]}</p>`,
            ]);
          });
        } else {
          alert("No data found!");
          reloadDataTable([]); // Reload table with empty response
        }
        new DataTable("#dataTable", {
          columns: [
            {
              title: ` <input type="checkbox" id="selectAllCheckbox"> 
                <br> No `,
            },
            {
              title: "Action",
            },
            {
              title: "Theater Name",
            },
            {
              title: "Thcode",
            },
            {
              title: "Ads Name",
            },
            {
              title: "Airdate",
            },
            {
              title: "Start Time",
            },
            {
              title: "End Time",
            },
            {
              title: "Region",
            },
            {
              title: "District",
            },
          ],
          data: dataSet,

          columnDefs: [
            {
              targets: 0,
              searchable: false,
              orderable: false,
              targets: [0], // Disable sorting for Checkbox and Serial Number columns
            }, // Disable searching for the Serial Number (No)
            {
              targets: 1,
              searchable: true,
            }, // Enable searching for the ID
            {
              targets: 2,
              searchable: true,
            }, // Enable searching for the Theater Name
            {
              targets: 3,
              searchable: true,
            }, // Enable searching for Thcode
            {
              targets: 4,
              searchable: true,
            }, // Enable searching for Ads Name
            {
              targets: 5,
              searchable: true,
            }, // Enable searching for Airdate
            {
              targets: 6,
              searchable: true,
            }, // Enable searching for Start Time
            {
              targets: 7,
              searchable: true,
            }, // Enable searching for End Time
            {
              targets: 8,
              searchable: true,
            }, // Enable searching for Region
            {
              targets: 9,
              searchable: true,
            },
          ],
          dom: "Bfrtip", // Enable Buttons
          buttons: [
            {
              extend: "csvHtml5",
              text: "Export CSV",
              className: "btn btn-primary",
            },
            {
              extend: "excelHtml5",
              text: "Export Excel",
              className: "btn btn-success",
            },
          ],
        });
      },
      error: function (xhr, status, error) {
        console.error("Error occurred while fetching data: ", error);
        alert("Failed to fetch data. No data found.");
        // Optionally, you can reload the table with no data
        reloadDataTable([]);
      },
    });
  });

  function reloadDataTable(response) {
    // Check if DataTable is already initialized and destroy it
    if ($.fn.dataTable.isDataTable("#dataTable")) {
      $("#dataTable").DataTable().clear().destroy();
    }
  }

  $("#editForm").on("submit", function (event) {
    event.preventDefault(); // Prevent default form submission

    $.ajax({
      url: "save_bulk_edit.php",
      type: "POST",
      data: $(this).serialize(),
      success: function (response) {
        $("#responseMessage").html(
          '<p class="alert alert-success">Records updated successfully!</p>'
        );
        $("#filterButton").click();

        // Remove the message after 3 seconds (3000 ms)
        setTimeout(function () {
          $("#responseMessage").fadeOut("slow", function () {
            $(this).html("").show(); // Clear and reset for future messages
          });
        }, 3000);
      },
      error: function () {
        $("#responseMessage").html(
          "<span style='color:red;'>Failed to save the record.</span>"
        );
      },
    });
  });

  $("#addExportFormBtn").on("click", function (event) {
    event.preventDefault(); // Prevent default form submission

    $.ajax({
      url: "add_data_report.php",
      type: "POST",
      data: $("#addExportForm").serialize(),
      success: function (response) {
        $("#responseMessage").html(
          '<p class="alert alert-success">Records added successfully!</p>'
        );
        $("#filterButton").click();

        // Close the modal with jQuery
        $("#addReportModal").modal("hide");
        $("#resetBtn").click();

        // Remove the message after 3 seconds (3000 ms)
        setTimeout(function () {
          $("#responseMessage").fadeOut("slow", function () {
            $(this).html("").show(); // Clear and reset for future messages
          });
        }, 3000);
      },
      error: function () {
        $("#responseMessage").html(
          "<span style='color:red;'>Failed to save the record.</span>"
        );
      },
    });
  });
});

// Handle Bulk Delete
$("#bulkDeleteButton").click(function () {
  const selectedIds = [];
  $(".rowCheckbox:checked").each(function () {
    selectedIds.push($(this).val());
  });

  if (selectedIds.length === 0) {
    alert("No rows selected for deletion.");
    return;
  }

  if (confirm("Are you sure you want to delete the selected rows?")) {
    // AJAX request for bulk delete
    $.ajax({
      url: "delete_data.php",
      type: "POST",
      data: {
        ids: selectedIds,
      },
      success: function (response) {
        $("#responseMessage").html(
          '<p class="alert alert-success">Selected rows deleted successfully!</p>'
        );
        $("#filterButton").click(); // Reload data after deletion

        // Remove the message after 3 seconds (3000 ms)
        setTimeout(function () {
          $("#responseMessage").fadeOut("slow", function () {
            $(this).html("").show(); // Clear and reset for future messages
          });
        }, 3000);
      },
      error: function (xhr, status, error) {
        console.error("Error occurred during bulk delete: ", error);
        $("#responseMessage").html(
          "<span style='color:red;'>Failed to delete selected rows. Please try again later.</span>"
        );
      },
    });
  }
});

// Handle Select All Checkbox
$(document).on("click", "#selectAllCheckbox", function () {
  const isChecked = $(this).is(":checked");
  $(".rowCheckbox").prop("checked", isChecked);
});

$(document).on("change", 'input[type="checkbox"].rowCheckbox', function () {
  // Check if any row checkboxes are selected
  if ($('input[type="checkbox"].rowCheckbox:checked').length > 0) {
    $("#bulkDeleteButton").css("display", "block"); // Show the button
  } else {
    $("#bulkDeleteButton").css("display", "none"); // Hide the button
  }
});

// Select/Deselect all rows
$(document).on("change", "#selectAllCheckbox", function () {
  const isChecked = $(this).is(":checked");
  $('input[type="checkbox"].rowCheckbox').prop("checked", isChecked);

  if (isChecked) {
    $("#bulkDeleteButton").css("display", "block"); // Show the button if all are selected
  } else {
    $("#bulkDeleteButton").css("display", "none"); // Hide the button if all are deselected
  }
});
 
function deleteData(id) {
    if (confirm("Are you sure you want to delete this record?")) {
        $.ajax({
            url: 'delete_data.php',
            type: 'GET',
            data: {
                id: id,
            },
            success: function(response) {
                $("#filterButton").click();
                $("#responseMessage").html('<p class="alert alert-success">Record deleted successfully!</span>');
                // Remove the message after 3 seconds (3000 ms)
                setTimeout(function () {
                    $("#responseMessage").fadeOut("slow", function () {
                        $(this).html("").show(); // Clear and reset for future messages
                    });
                }, 3000);
            }
        });
    }
}
 