$(window).ready(function () {

  $(".addChild").click(function () {
    // klonuojame formos eilutę
    rowClone = $(".formRowsContainer").find(".formRow:first").clone(true, true);

    // pašaliname disabled požymius ir paslėpimo klasę
    $(rowClone).find("input[type=text], select").prop('disabled', false);
    $(rowClone).removeClass('d-none');

    // klonuotą eilutę įtraukiame į formos eilučių konteinerį
    rowClone.appendTo($(".formRowsContainer"));

    // paslėpimo klasę pašaliname iš formos antraštės eilutės
    $(".headerRow").removeClass("d-none");

    //
    return false;
  })

  $(".removeChild").click(function () {
    // pašaliname formos eilutę, kuriai priklauso paspaustas mygtukas
    $(this).closest(".formRow").remove();

    // jeigu pašalinta paskutinė eilutė, paslepiame formos antraštę
    if ($(".formRowsContainer").find('.formRow').size() == 1) {
      $(".headerRow").addClass("d-none");
    }

    //
    return false;
  })

});

function showConfirmDialog(module, removeId) {
  var r = confirm("Ar tikrai norite pašalinti!");
  if (r === true) {
    window.location.replace("index.php?module=" + module + "&action=delete&id=" + removeId);
  }
}


var modalConfirm = function (callback) {

  $("#btn-confirm").on("click", function () {
    $("#confirm-delete").modal('show');
  });

  $("#modal-btn-si").on("click", function () {
    callback(true);
    $("#confirm-delete").modal('hide');
  });

  $("#modal-btn-no").on("click", function () {
    callback(false);
    $("#confirm-delete").modal('hide');
  });
};

modalConfirm(function (confirm) {
  if (confirm) {
    //Acciones si el usuario confirma
    //$("#result").html("CONFIRMADO");
    alert(1);
  } else {
    //Acciones si el usuario no confirma
    //$("#result").html("NO CONFIRMADO");
    alert(2);
  }
});