<template>
  <div class="min-h-screen bg-gray-100 py-6 flex flex-col">
    <div class="container mx-auto">
      <add-task-form v-on:refreshlist="getList()" />
      <task-list-view :tasks="tasks" v-on:refreshlist="getList()" />
    </div>
  </div>
</template>

<script>
import AddTaskForm from "./components/AddTaskForm";
import TaskListView from "./components/TaskListView";

export default {
  components: {
    AddTaskForm,
    TaskListView,
  },
  data: function () {
    return { tasks: [] };
  },
  methods: {
    getList() {
      axios
        .get("api/tasks")
        .then((res) => (this.tasks = res.data))
        .catch((err) => console.error(err));
    },
  },
  created() {
    this.getList();
  },
};
</script>