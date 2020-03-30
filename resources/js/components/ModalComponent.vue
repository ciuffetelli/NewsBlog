<template>
    <div class="modal fade" :id="(id || 'modal')" tabindex="-1" role="dialog" aria-labelledby="Login" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="p-1">
                    <slot></slot>
                </div>
                <div class="modal-body p-1">
                    <slot name="content"></slot>
                </div>
                <div class="modal-footer">
                    <slot name="footer"></slot>
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
    export default {
        props: ['id'],
        mounted() {
        }
    }
</script>
