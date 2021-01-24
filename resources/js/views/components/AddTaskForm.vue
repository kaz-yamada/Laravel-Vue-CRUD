<template>
  <div class="w-full flex mb-4 h-14 relative">
    <input
      type="text"
      name="taskName"
      id="taskName"
      v-model="task.name"
      placeholder="Add a new task"
      class="bg-white rounded-lg w-full focus:outline-none border text-lg h-full px-4"
    />
    <button
      type="submit"
      @click="addTask()"
      class="right-4 inset-y-2 absolute focus:outline-none text-white bg-green-500 hover:bg-green-700"
    >
      <PlusIcon class="w-full w-full" />
    </button>
  </div>
</template>

<script>
import { PlusIcon } from "@vue-hero-icons/outline";

export default {
  components: { PlusIcon },
  data: function () {
    return {
      task: {
        name: "",
      },
    };
  },
  methods: {
    addTask() {
      if (this.task.name === "") return;

      axios
        .post("api/task/store", { task: this.task })
        .then((res) => {
          if (res.status === 201) {
            this.task.name = "";
            this.$emit("refreshlist");
          }
        })
        .catch((err) => {
          console.error(err);
        });
    },
  },
};
</script>