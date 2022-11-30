import {checkIfModelHasEmptyProperties, toObjectRequest} from "@/HelperFunctions";

export default class Campus {
    toObjectRequest() {
        return toObjectRequest(this, true);
    }

    hasEmptyProperties() {
        return checkIfModelHasEmptyProperties(this);
    }

    static fromModel(model) {
        return new Campus(model.id, model.name, model.city, model.university_id);
    }

    constructor(id = null, name = '', city = '', university_id = null) {
        this.id = id;
        this.name = name;
        this.city = city;
        this.university_id = university_id;

        this.dataStructure = {
            id: null,
            name: 'required',
            city: 'required',
            university_id: 'required',
        }
    }
}
