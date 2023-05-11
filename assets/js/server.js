class server {
  url = "server.php?";
  get(path = "") {
    let urlApi = this.url + path;
    return new Promise(function (resolve, reject) {
      $.ajax({
        url: urlApi,
        type: "GET",
        dataType: "json",
        processData: false,
        contentType: false,
      })
        .done(function (res, req) {
          resolve(res, req);
        })
        .fail(function (xhr, status, error) {
          reject(xhr, status, error);
        });
    });
  }
  post(path = "", Data = "") {
    let urlApi = this.url + path;
    return new Promise(function (resolve, reject) {
      $.ajax({
        url: urlApi,
        type: "POST",
        data: Data,
        dataType: "json",
        processData: false,
        contentType: false,
      })
        .done(function (res, req) {
          resolve(res, req);
        })
        .fail(function (xhr, status, error) {
          reject(xhr, status, error);
        });
    });
  }
  delete(path = "", Data = "") {
    let urlApi = this.url + path;
    return new Promise(function (resolve, reject) {
      $.ajax({
        url: urlApi,
        type: "DELETE",
        data: Data,

        processData: false,
        contentType: false,
      })
        .done(function (res, req) {
          resolve(res, req);
        })
        .fail(function (xhr, status, error) {
          reject(xhr, status, error);
        });
    });
  }
}
