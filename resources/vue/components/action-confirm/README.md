## Action Confirm

A simple vue+veutify plugin that can be use show confirmation dialog
and provide callback on user confirm action

#### Import and use
```
import ActionConfirm from "/path/to/component";

Vue.use(ActionConfirm);
```

#### Usage
```
const confirmed = await this.$confirm("Are you sure?"[,options]);

if(confirmed){
    // do something
}
```