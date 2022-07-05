<template>
  <div class="qtwrap">
    <div class="floth columnes">
      <div class="postbox-container">
        <div class="postbox menu__area">
          <div class="postbox-header">
            <h2 class="pbhead" v-html="lang.fsettings" />
          </div>
          <div class="inside columesinputs">
            <div>
              <label for="flarum_db_host">{{lang.fdh}}</label>
              <input type="text" name="flarum_db_host" id="flarum_db_host" :placeholder="lang.fdh" autocomplete="off" v-model="flarumData.host" />
            </div>
            <div>
              <label for="flarum_db_table">{{lang.fdt}}</label>
              <input type="text" name="flarum_db_table" id="flarum_db_table" :placeholder="lang.fdt" autocomplete="off" v-model="flarumData.table" />
            </div>
            <div>
              <label for="flarum_db_username">{{lang.fdu}}</label>
              <input type="text" name="flarum_db_username" id="flarum_db_username" :placeholder="lang.fdu" autocomplete="off" v-model="flarumData.user" />
            </div>
            <div>
              <label for="flarum_db_password">{{lang.fdp}}</label>
              <input type="password" name="flarum_db_password" id="flarum_db_password" :placeholder="lang.fdp" autocomplete="off" v-model="flarumData.password" />
            </div>
            <div>
              <label for="flarum_dflarum_db_portb_port">{{lang.fdbp}}</label>
              <input type="text" name="flarum_db_port" id="flarum_db_port" :placeholder="lang.fdbp" autocomplete="off" v-model="flarumData.port" />
            </div>

          </div>
          <div class="postbox-footer">
            <button class="button button-secondary" @click="checkDatabase">Check Database</button>
            <button class="button button-primary" @click="saveDetails">Save Details</button>
          </div>
        </div>
      </div>
      <div class="postbox-container">
        <div class="postbox menu__area">
          <div class="postbox-header">
            <h2 class="pbhead" v-html="lang.fsettings" />
          </div>
          <div class="inside">
            <!-- Content will be here-->
          </div>
          <div class="postbox-footer"></div>
        </div>
      </div>
    </div>
    <div class="fl20">
      <rightSidebar />
    </div>
  </div>
  <ftw-toast :message="toastMessage" :isActive="isToastActive" :textColor="toastText" :background="toastBack" />
</template>

<script>
import "@/css/system.scss";

import ftwToast from "@/components/ftwToast.vue";
import rightSidebar from "./components/rightSideBar.vue";

export default {
  components: { ftwToast, rightSidebar },
  data() {
    return {
      currentPath: window.location.hash,
      toastMessage: "",
      isToastActive: false,
      toastBack: null,
      toastText: null,
      flarumData: {
        host: "",
        user: "",
        table: "",
        password: "",
        port: 3306,
      },
    };
  },
  computed: {
    lang() {
      return ftw_object.language;
    },
  },
  methods: {
    async checkDatabase() {
      console.log(this.flarumData);
      if (
        this.flarumData.host !== "" &&
        this.flarumData.user !== "" &&
        this.flarumData.table !== "" &&
        this.flarumData.password !== ""
      ) {
        this.isToastActive = true;
        this.toastMessage = "Checking Database...";
        let formData = new FormData();
        formData.append("action", "check_other_database");
        formData.append("flarum_db_host", this.flarumData.host);
        formData.append("flarum_db_table", this.flarumData.table);
        formData.append("flarum_db_username", this.flarumData.user);
        formData.append("flarum_db_password", this.flarumData.password);
        formData.append("flarum_db_port", this.flarumData.port);
        formData.append("security", ftw_object.security);
        const rawResponse = await fetch(ftw_object.ajaxurl, {
          method: "POST",
          body: formData,
        });
        const respo = await rawResponse.json();
        if (respo.success) {
          console.log(respo.data);
        } else {
          console.log("error");
        }
      } else {
        this.isToastActive = false;
        this.toastMessage = "Something Wrong";
        this.isToastActive = true;
        this.toastBack = "#f8d7da";
        this.toastText = "#842029";
      }

      setTimeout(() => {
        this.isToastActive = false;
        this.toastMessage = "";
        console.log(this.isToastActive);
      }, 2500);
    },
    saveDetails() {
      console.log("Save Database");
    },
  },
  mounted() {
    //console.log(this.lang);
  },
};
</script>
