<template>
  <el-button type="text" @click="open4">点击打开 Message Box</el-button>
</template>

<script>
  export default {
    methods: {
      open4() {
        this.$msgbox({
          title: '消息',
          message: '这是一段内容, 这是一段内容, 这是一段内容, 这是一段内容, 这是一段内容, 这是一段内容, 这是一段内容',
          showCancelButton: true,
          confirmButtonText: '确定',
          cancelButtonText: '取消'
        }).then(action => {
          this.$message({
            type: 'info',
            message: 'action: ' + action
          });
        });
      },
    }
  }
</script>