<template>
  <div id="simpleToast" :class="isActive ? `showToast`: ''" :style="{backgroundColor:background || '#2271b1',color:textColor || '#ffffff'}">
    <span>{{message}}</span>
  </div>
</template>

<script>
export default {
  name: "ftwToast",
  props: {
    message: {
      type: String,
      required: true,
    },
    isActive: {
      type: Boolean,
      default: false,
    },
    textColor: {
      type: String,
      default: "#FFFFFF",
    },
    background: {
      type: String,
      default: "#2271b1",
    },
  },
};
</script>

<style lang="scss" scoped>
#simpleToast {
  visibility: hidden;
  min-width: 250px;
  margin-left: -125px;
  text-align: center;
  border-radius: 2px;
  padding: 16px;
  position: fixed;
  z-index: 1;
  left: 50%;
  bottom: 30px;
  font-family: monospace;
  display: inline-flex;
  line-height: 12px;
  span {
    margin-left: 12px;
    margin-top: 2px;
  }
}
.showToast {
  visibility: visible !important;
  -webkit-animation: fadein 0.5s, fadeout 0.5s 2.5s;
  animation: fadein 0.5s, fadeout 0.5s 2.5s;
}
@-webkit-keyframes fadein {
  from {
    bottom: 0;
    opacity: 0;
  }
  to {
    bottom: 30px;
    opacity: 1;
  }
}

@keyframes fadein {
  from {
    bottom: 0;
    opacity: 0;
  }
  to {
    bottom: 30px;
    opacity: 1;
  }
}

@-webkit-keyframes fadeout {
  from {
    bottom: 30px;
    opacity: 1;
  }
  to {
    bottom: 0;
    opacity: 0;
  }
}

@keyframes fadeout {
  from {
    bottom: 30px;
    opacity: 1;
  }
  to {
    bottom: 0;
    opacity: 0;
  }
}
</style>
