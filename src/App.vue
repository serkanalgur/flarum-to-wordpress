<template>
  <div class="qtwrap">
    <div class="flother"></div>
    <div class="fl20">
      <div class="postbox-container">
        <div class="postbox menu__area">
          <div class="postbox-header">
            <h2 class="pbhead">Recommended Theme</h2>
          </div>
          <div class="inside">
            <a class="out" href="https://github.com/sinanisler/SiForum" target="_blank">
              <img class="centerme" src="@/img/siforum.png" />
            </a>
          </div>
        </div>
      </div>
    </div>
  </div>
</template>

<script>
import "@/css/system.scss";
export default {
  data() {
    return {
      currentPath: window.location.hash,
    };
  },

  mounted() {
    console.log("Hello");
  },
};
</script>
