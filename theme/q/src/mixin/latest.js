const latest = {
  methods: {
    latest(bo_table, rows, subject_len) {
      let formData = new FormData();
      formData.append("latest", true);
      formData.append("bo_table", bo_table);
      formData.append("rows", rows);
      formData.append("subject_len", subject_len);
      return fetch(window.url, {
        method: "post",
        body: formData,
      })
      .then(function(response) {
        return response.json();
      })
      .then(function(json) {
        return json;
      });
    },
  },
};
export default latest;
