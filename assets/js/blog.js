function formatDate(date) {
  var d = new Date(date),
    month = "" + (d.getMonth() + 1),
    day = "" + d.getDate(),
    year = d.getFullYear();

  if (month.length < 2) month = "0" + month;
  if (day.length < 2) day = "0" + day;

  return [year, month, day].join("-");
}
function views() {
  let url = window.location.href;
  console.log("🚀 ~ file: blog.js:3 ~ views ~ url:", url.search("&id="));
  let Server = new server();

  if (url.search("&id=") == -1) {
    Server.get("action=blog")
      .then((res, req) => {
        console.log(res.data);
        let result = "";
        for (let i of res.data) {
          result += ` <div class="container p-3 mt-2">
         <h4 class="text-muted">BLOG</h4>
         <a href="index.php?action=blog&id=${i.id}" class="h2 mb-2" style="cursor: pointer;">${i.title}</a>
         <div class="w-25 bg-black m-3" style="height:.5px"></div>
         <a href="index.php?action=blog&id=${i.id}" class="text-center">

             <img style="object-fit: cover; width:100%" src="${
               i.avatar
             }" alt="">
         </a>
         <p class="m-4" style="font-size: 1.3rem;">${
           i.content.split("<p>")[1].split("</p>")[0]
         }</p>
         <a href="index.php?action=blog&id=${i.id}" class="h4 my-4 mx-3" style="color:#5bbcc0">Continue reading →</a>
         <div class="border-top border-bottom p-3 mt-4 ">
             <div class="d-flex">

                 <div style="overflow: hidden;height:50px;width:50px;border-radius: 25px;">
                     <img style="width:100%;height:100%;object-fit: cover;" src="https://demo.focuxtheme.com/dgwork/wp-content/uploads/sites/13/2016/08/dgwork-header-devices.jpg" alt="">

                 </div>
                 <div class="author-info ms-2">
                     <span class="name-author h6">${i.fullname}</span>
                     <p class="date-created text-muted">${formatDate(
                       i.created_at
                     )}</p>
                 </div>

             </div>

         </div>

     </div>`;
        }
        $("#blog").html(result);
      })
      .catch((xhr, status, error) => {
        console.log(xhr, status, error);
      });
  }
  else {
    Server.get(`action=blog&id=${url.split('&id=')[1]}`).then((res,req)=>{

        console.log(res);
        $("#body > div.img-top > div > h1").text(res.title)
        $("#body > div.img-top > div > h3").text(formatDate(res.created_at)+" / Blog / "+res.fullname)
        
        $("#blog").html(res.content);

    }).catch((xhr,status,error)=>{
        console.log(xhr,status,error);

    })
  }
}
$(document).ready(function () {
  views();
});
