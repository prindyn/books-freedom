export default {
    methods: {
        asset(path) {
            var base_path = window._asset || '';
            console.log(base_path + path)
            return base_path + path;
        }
    }
}