// Validation errors messages for Parsley
import Parsley from '../parsley';

Parsley.addMessages('sk', {
  defaultMessage: "Táto položka je neplatná.",
  type: {
    email:        "Táto položka musí byť e-mailová adresa.",
    url:          "Táto položka musí byť platná URL adresa.",
    number:       "Táto položka musí byť číslo.",
    integer:      "Táto položka musí byť celé číslo.",
    digits:       "Táto položka musí byť kladné celé číslo.",
    alphanum:     "Táto položka musí byť alfanumerická."
  },
  notblank:       "Táto položka nesmie byť prázdná.",
  required:       "Táto položka je povinná.",
  pattern:        "Táto položka je neplatná.",
  min:            "Táto položka musí byť väčšia alebo rovna %s.",
  max:            "Táto položka musí byť menšia alebo rovna %s.",
  range:          "Táto položka musí byť v rozsahu od %s do %s.",
  minlength:      "Táto položka musí mať najmenej %s znakov.",
  maxlength:      "Táto položka musí mať najviac %s znakov.",
  length:         "Táto položka musí mať dĺžku od %s do %s znakov.",
  mincheck:       "Je nutné vybrať aspoň %s možností.",
  maxcheck:       "Je nutné vybrať najviac %s možností.",
  check:          "Je nutné vybrať od %s do %s možností.",
  equalto:        "Táto položka musí byť rovnaká."
});

Parsley.setLocale('sk');
