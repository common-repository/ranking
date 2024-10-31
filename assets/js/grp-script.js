window.addEventListener("load", function () {
  var tabs = document.querySelectorAll("ul.nav-tabs > li");

  for (var i = 0; i < tabs.length; i++) {
    tabs[i].addEventListener("click", switchTab);
  }

  function switchTab(event) {
    event.preventDefault();

    document.querySelector("ul.nav-tabs li.active").classList.remove("active");
    document.querySelector(".tab-pane.active").classList.remove("active");

    var clickedTab = event.currentTarget;
    var anchor = event.target;
    var activePaneID = anchor.getAttribute("href");

    clickedTab.classList.add("active");
    document.querySelector(activePaneID).classList.add("active");
  }

  /**
   * 複製 website url
   */
  var inputElement = document.querySelector(
    "input[name='gcreate_ranking_post_website']"
  );
  var copyButton = document.getElementById("copyButton");
  var customDialog = document.getElementById("customDialog");

  copyButton.addEventListener("click", function () {
    inputElement.select();
    inputElement.setSelectionRange(0, 99999);
    document.execCommand("copy");
    inputElement.setSelectionRange(0, 0);

    // 顯示自定義對話框
    customDialog.style.display = "block";

    // 2秒後隱藏對話框
    setTimeout(function () {
      customDialog.style.display = "none";
    }, 2000); // 2秒後隱藏
  });

  /**
   * 複製 website url
   */
  var RankingPostInput = document.querySelector(
    "input[name='gcreate_ranking_post_website_api']"
  );
  var copyButton2 = document.getElementById("copyButton2");
  var customDialog2 = document.getElementById("customDialog2");

  copyButton2.addEventListener("click", function () {
    RankingPostInput.select();
    RankingPostInput.setSelectionRange(0, 99999);
    document.execCommand("copy");
    RankingPostInput.setSelectionRange(0, 0);

    // 顯示自定義對話框
    customDialog2.style.display = "block";

    // 2秒後隱藏對話框
    setTimeout(function () {
      customDialog2.style.display = "none";
    }, 2000); // 2秒後隱藏
  });
});
