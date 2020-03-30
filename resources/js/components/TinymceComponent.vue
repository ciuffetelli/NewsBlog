<template>
  <div class="tinymce-edit">
    <editor

      :initialValue="getHTML"
      :name="name"
      
      apiKey="5sldr9i02ptp6n0h7qd7ph39kyjcbmx241p8079zvs8laeuf"
      :init="{
        height: 500,
        menubar: false,
        plugins: [
          'advlist autolink lists link image pagebreak charmap',
          'searchreplace visualblocks code fullscreen',
          'print preview anchor insertdatetime media',
          'paste code help wordcount table'
        ],
        toolbar: 'undo redo | bold italic underline strikethrough | fontselect fontsizeselect formatselect | alignleft aligncenter alignright alignjustify | outdent indent |  numlist bullist checklist | forecolor backcolor casechange permanentpen formatpainter removeformat | pagebreak | charmap emoticons | fullscreen  preview save print | insertfile image media pageembed template link anchor codesample | a11ycheck ltr rtl | showcomments addcomment',
      }"
    ></editor>
  </div>
</template>
<script>
    
    import Editor from '@tinymce/tinymce-vue';

    export default {
        props: ['name', 'id', 'data'],
        data() {
          return {
          }
        },
        watch:{
        },
        components: {
            editor: Editor
        },
        computed:{
          getHTML(){
              return this.data;
          }
        },
        methods:{
        },
        mounted() {
        }
    }
</script>
<style>
.tinymce-edit{
  width: 100%;
  height: 500px;
  background: #666;
}
</style>