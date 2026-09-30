import { Injectable } from '@angular/core';
import { HttpClient } from '@angular/common/http';
import { Observable, map } from 'rxjs';

import { DJANGO } from '../backend';
import { Aviso, NuevoAviso } from '../modelos/aviso';

@Injectable({
  providedIn: 'root'
})
export class AvisosService {

  constructor(private http: HttpClient) { }

  // DRF pagina con { results } y exige la barra final; Laravel usa { data } y no la lleva.
  private url = DJANGO ? '/api/avisos/' : '/api/avisos';

  listar(): Observable<Aviso[]> {
    return this.http.get<{ data?: Aviso[]; results?: Aviso[] }>(this.url).pipe(
      map(respuesta => (DJANGO ? respuesta.results : respuesta.data) ?? [])
    );
  }

  crear(aviso: NuevoAviso): Observable<Aviso> {
    return this.http.post<{ data: Aviso } & Aviso>(this.url, aviso).pipe(
      map(respuesta => DJANGO ? respuesta : respuesta.data)
    );
  }

  borrar(id: number): Observable<void> {
    return this.http.delete<void>(DJANGO ? `${this.url}${id}/` : `${this.url}/${id}`);
  }

}
