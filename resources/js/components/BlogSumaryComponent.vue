<template>
    <div class="row w-100">
        <div class="col"></div>
        <div class="col">
          <button type="button" class="btn btn-outline-primary" style="float: right"
              data-toggle="collapse" data-target="#summary" aria-expanded="false">Summary</button>            
        </div>
        <div class="col">
            <div class="custom-control custom-switch">
              <input type="checkbox" class="custom-control-input" v-model="auto">
              <label class="custom-control-label" for="autoSummary">auto build
                <a :href="helpURL" target="_new">
                  <i class="fas fa-question-circle" title="help"></i>
                </a>                   
              </label>
            </div>            
        </div>
        <div class="col"></div>

        <div class="form-row collapse w-100 mx-auto" id="summary">
            <div class="col-md-12 mb-3">
                <label for="summary">summary
                    <a :href="helpURL" target="_new">
                        <i class="fas fa-question-circle" title="help"></i>
                    </a> 
                </label>
            <tinymce name="summary" :data="value"></tinymce>
            </div>        
        </div>
    </div>        
</template>
<script>
export default {
    props: ['name', 'value'],
    data(){
        return {
            helpURL: config.root + '/help#summary',
            auto: true,
        }
    },
}
</script>   