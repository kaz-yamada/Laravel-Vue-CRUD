<template>
  <div class="w-full bg-white border rounded-lg p-4">
    <div v-if="tasks.length === 0">No tasks found</div>
    <task-item
      v-for="(task, index) in tasks"
      :key="index"
      :task="task"
      v-on:taskupdated="$emit('refreshlist')"
    />
  </div>
</template>

<script>
import TaskItem from "./TaskItem";

export default {
  props: ["tasks"],
  components: {
    TaskItem,
  },
};
</script>