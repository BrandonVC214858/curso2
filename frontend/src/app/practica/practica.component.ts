import { Component, OnInit } from '@angular/core';

import { AvisosService } from '../servicios/avisos.service';

@Component({
  selector: 'app-practica',
  templateUrl: './practica.component.html',
  styleUrls: ['./practica.component.css']
})
export class PracticaComponent implements OnInit {
  nombre = 'Guardia nocturna';
  turnos = 3;
  hoy = new Date();
  pendientes = ['Revisar radios', 'Entregar reporte', 'Cambiar llantas'];
  nuevo = '';
  total = 0;

  constructor(private avisosService: AvisosService) { }

  ngOnInit(): void {
    this.avisosService.listar().subscribe(avisos => this.total = avisos.length);
  }


  
  sumar(): void {
    this.turnos++;
  }

  agregar(): void {
    this.pendientes.push(this.nuevo.trim());
    this.nuevo = '';
  }

}
