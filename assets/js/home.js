let follows = document.querySelectorAll("#body .follow-point .point");

follows.forEach((follows) => {
  let startValue = parseFloat(follows.getAttribute("data-duration"));
  let endValue = parseFloat(follows.getAttribute("data-val"));
  let setTime = endValue / startValue / 100;
  let counter = setInterval(function () {
    if (endValue >= 1000) {
      startValue += 10;
    } else {
      startValue += 1;
    }

    follows.textContent = startValue
      .toString()
      .replace(/\B(?=(\d{3})+(?!\d))/g, ",");
    if (startValue == endValue) {
      clearInterval(counter);
    }
  }, setTime);
});

// onte-stop
if (document.querySelector(".typewrite")) {
  let TxtType = function (el, toRotate, period) {
    console.log();
    this.toRotate = toRotate;
    this.el = el;
    this.loopNum = 0;
    this.period = parseInt(period, 10) || 2000;
    this.txt = "";
    this.tick();
    this.isDeleting = false;
  };

  TxtType.prototype.tick = function () {
    let i = this.loopNum % this.toRotate.length;
    let fullTxt = this.toRotate[i];

    if (this.isDeleting) {
      this.txt = fullTxt.substring(0, this.txt.length - 1);
    } else {
      this.txt = fullTxt.substring(0, this.txt.length + 1);
    }

    this.el.innerHTML = '<span class="wrap" >' + this.txt + "</span>";

    let that = this;
    let delta = 200 - Math.random() * 100;

    if (this.isDeleting) {
      delta /= 2;
    }

    if (!this.isDeleting && this.txt === fullTxt) {
      delta = this.period;
      this.isDeleting = true;
    } else if (this.isDeleting && this.txt === "") {
      this.isDeleting = false;
      this.loopNum++;
      delta = 500;
    }

    setTimeout(function () {
      that.tick();
    }, delta);
  };

  window.onload = function () {
    let elements = document.getElementsByClassName("typewrite");
    for (let i = 0; i < elements.length; i++) {
      let toRotate = elements[i].getAttribute("data-type");
      let period = elements[i].getAttribute("data-period");
      if (toRotate) {
        new TxtType(elements[i], JSON.parse(toRotate), period);
      }
    }
    // INJECT CSS
    let css = document.createElement("style");
    css.type = "text/css";
    css.innerHTML = ".typewrite > .wrap { border-right: 0.08em solid #000000;}";
    document.body.appendChild(css);
  };
}
function toCart(id) {
  let data = new FormData()
  let Server = new server();
  data.append("id", id);
  Server.post("action=cart", data).then((res, req) => {
    // window.location.href="index.php?action=cart";
  })
    .catch((xhr, status, error) => {
      console.log(xhr);
    }).finally(() => {
      window.location.href = "index.php?action=cart";
    });
}
function checkLibary(id) {
  let Server = new server();
  Server.get(`action=payment&function=check_Library&id=${id}`)
    .then((res, req) => {

      if (res.message) {
        $(`#creative-icon-${id}`).html(` <span class="plus" style="--bg: #fff; --color: #34b7ae"><a href="index.php?action=shop&act=detail&id=${id}">
  
  
    <i class="fa-solid fa-eye"></i>
</a> </span>`)
      }
    })
    .catch((xhr, status, error) => {

      console.log(xhr, status, error);
    });
}
$(document).ready(function () {
  let Server = new server();
  Server.get("action=product")
    .then((res, req) => {
      let result = "";

      for (let i of res.data) {
        let price = [];
        for (let j of i.options) {

          price.push(formatCurrency(j.price));
        }

        result += `
          <div class="col-lg-4 col-md-6">
              <div class="card">
                  <div class="creative-img-cover">
                      <img class="card-img-top" src="${i.img}" alt="${i.img}" style="width: 100%; min-height:200px" />
                      <div class="creative-icon"id="creative-icon-${i.id}">
                          <span class="plus" style="--bg: #fff; --color: #34b7ae">
                              <a href="index.php?action=payment&id=${i.id}">
    
    
                                  <i class="fa-solid fa-plus"></i>
                              </a>
                          </span>
                          <span class="cart" style="--bg: #34b7ae; --color: #fff;cursor:pointer"><a a onclick=" toCart(${i.id})"><i class="fa-solid fa-cart-shopping"></i></a>
                          </span>
                      </div>
                  </div>
    
                  <div class="card-body">
                      <a href="index.php?action=shop&cate=${i.category_id}" class="heading-note">${i.name}</a>
                      <br>
                      <a href="index.php?action=shop&act=detail&id=${i.id}" class="card-title h5 text-dark" style="text-decoration: none;">${i.title}</a>
                      <p class="card-text card-price">
                          <span>
                          ${price}
    
    
    
                          </span>
                      </p>
                  </div>
              </div>
          </div>
    `;
        $("#product").html(result);
        checkLibary(i.id)
      }
    })
    .catch((xhr, statu, error) => {
      console.log(error);
    });

  Server.get("action=product&function=category")
    .then((res, req) => {
      let result = "";
      let count = 0;
      for (let i of res) {
        if (count > 3) {
          break;
        }
        if (i.id != 0) {

          result += `<li><a href="index.php?action=shop&cate=${i.id}">${i.name}</a></li>`;
          count++;
        }

      }

      $("#category").html(result);
    })
    .catch((x, st, err) => {
      console.log(x);
    });
});
