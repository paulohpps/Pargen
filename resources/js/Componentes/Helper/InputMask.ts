import Inputmask from "inputmask";

export default class Mask {
    static maskValor = {
        alias: "currency",
        prefix: "R$ ",
        rightAlign: false,
        digits: 2,
        radixPoint: ",",
        groupSeparator: ".",
        placeHolder: "0",
        autoUnmask: true,
        unmaskAsNumber: true,
        inputType: "number",
    }

    static maskCPF = { mask: '999.999.999-99', inputmode: 'numeric' }

    static valor(element){
        return Inputmask(this.maskValor).mask(element);
    }

    static cpf(element){
        return Inputmask(this.maskCPF).mask(element);
    }
}
