function userInfo() {
  let Server = new server();
  Server.get("action=user")
    .then((res, req) => {
      $("#body > div.img-top > div > h1").text(res.fullname);
    })
    .catch((xhr, status, err) => {});
}
$(document).ready(()=>{
    userInfo();
})