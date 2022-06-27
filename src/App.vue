<template>
  <div class="qtwrap">
    <div class="floth">
      <div class="postbox-container">
        <div class="postbox menu__area">
          <div class="postbox-header">
            <h2 class="pbhead" v-html="lang.fsettings" />
          </div>
          <div class="inside">
            <!-- Content will be here-->
          </div>
        </div>
      </div>
    </div>
    <div class="fl20">
      <div class="postbox-container">
        <div class="postbox menu__area">
          <div class="postbox-header">
            <h2 class="pbhead" v-html="lang.author" />
          </div>
          <div class="inside">
            <div class="author_info">
              <div class="image">
                <img :src="serkanalgur" />
              </div>
              <div class="info">
                <h3>Serkan Algur</h3>
                <ul>
                  <li>
                    <span class="dashicons dashicons-email"></span>&nbsp;
                    <a href="mailto:selam@serkanalgur.com.tr">selam@serkanalgur.com.tr</a>
                  </li>
                  <li>
                    <span class="dashicons dashicons-twitter"></span>&nbsp;
                    <a href="https://twitter.com/serkanalgur" target="_blank">@serkanalgur</a>
                  </li>
                  <li>
                    <img :src="github" width="20" style="vertical-align: middle;" />&nbsp;
                    <a href="https://github.com/serkanalgur" target="_blank">@serkanalgur</a>
                  </li>
                  <li>
                    <span class="dashicons dashicons-admin-site"></span>&nbsp;
                    <a href="https://serkanalgur.com.tr" target="_blank">serkanalgur.com.tr</a>
                  </li>
                </ul>
              </div>
            </div>
          </div>
        </div>
      </div>
      <div class="postbox-container">
        <div class="postbox menu__area">
          <div class="postbox-header">
            <h2 class="pbhead" v-html="lang.rtheme" />
          </div>
          <div class="inside">
            <a class="out" href="https://github.com/sinanisler/SiForum" target="_blank">
              <img class="centerme" :src="siforum" />
            </a>
          </div>
        </div>
      </div>
    </div>
  </div>
</template>

<script>
import "@/css/system.scss";
import siforum from "@/img/siforum.png";
import serkanalgur from "@/img/serkan_algur.jpg";
import github from "@/img/github.png";
export default {
  data() {
    return {
      currentPath: window.location.hash,
      siforum,
      serkanalgur,
      github,
    };
  },
  computed: {
    lang() {
      return ftw_object.language;
    },
  },
  mounted() {
    console.log(this.lang);
  },
};
</script>
