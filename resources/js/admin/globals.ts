import {AxiosStatic} from "axios";

export {}

declare global {
    interface Window {
        axios: AxiosStatic
    }
}
