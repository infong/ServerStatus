function test(id, tagId) {
  // Fork it
  var request;
  // fire off the request to /form.php
  request = $.ajax({
    url: "pull.php",
    type: "get",
    //async: false,
    dataType: "json",
    data: {url: id},
    beforeSend: function () {
      $('#' + tagId).find("small").html("").addClass('fa fa-spinner fa-spin');
    }
  });

  request.done(function (result, textStatus, jqXHR) {
    $("#online" + id).html(result.online);
    $("#uptime" + id).html(result.uptime);
    $("#load" + id).html(result.load);
    $("#memory" + id).html(result.memory);
    $("#hdd" + id).html(result.hdd);
     $('#' + tagId).find("small").removeClass('fa fa-spinner fa-spin');
  });

  // callback handler that will be called on failure
  request.fail(function (jqXHR, textStatus, errorThrown) {
    // log the error to the console
    console.error(
      "The following error occured: " +
      textStatus, errorThrown
    );
     $('#' + tagId).find("small").html('Error').removeClass('fa fa-spinner fa-spin');
  });


}

