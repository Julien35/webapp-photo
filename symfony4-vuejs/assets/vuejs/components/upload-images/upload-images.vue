<template>
    <div class="area-container">

        <form id="image-form" enctype="multipart/form-data"
              method="post" name="fileinfo">
            <input name="file" id="input-file" type="file" multiple>
            <div id="prev"></div>

            <button type="button">Cancel</button>
            <input type="submit" value="Upload Photo"/>
        </form>

    </div>
</template>

<script>
    export default {
        name: "upload-images"
    }
</script>

<style scoped>

</style>