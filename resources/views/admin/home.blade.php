<template>
    <div class="page mainpage page-{{$pagename}}">
      <div class="page-content tw-border-init">
          <section class="content-section">
              home
          </section>
      </div>
    </div>
  </template>
  <script>
      export default function (props, ctx) {
          var $$f7router = ctx.$f7router;
          var $$el = ctx.$el;
          var $$f7 = ctx.$f7;
          var $$onMounted = ctx.$onMounted;
          var $$on = ctx.$on;

          $$on('pageBeforeIn', (e, page) => {
          })
          $$on('pageAfterIn', (e, page) => {
          })
          $$on('pageBeforOut',()=>{
          })
          return $render;
      }
  </script>  